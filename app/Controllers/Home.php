<?php

namespace App\Controllers;

use App\Models\SnapModel;
use App\Models\InvoiceModel;
use App\Models\TransactionModel;

class Home extends BaseController
{
	public function __construct()
	{
		$this->snap = new SnapModel();
		$this->trans = new TransactionModel();
		$this->invoice = new InvoiceModel();
		$this->db = \Config\Database::connect();
		$this->request = \Config\Services::request();
	}

	public function index()
	{
		$password = $this->request->getGet('password');

		$data = [
			'title' => 'My Midtrans Project',
			'password' => $password,
		];

		return view('index', $data);
	}

	public function store()
	{
		$invoice_code = substr(str_shuffle("0123456789"), 0, 10);
		$first_name = $this->request->getPost('first_name');
		$last_name = $this->request->getPost('last_name');
		$email = $this->request->getPost('email');
		$phone = $this->request->getPost('phone');
		$description = $this->request->getPost('description');
		$amount = $this->request->getPost('amount');

		$invoices = [
			'client_name' => "$first_name $last_name",
			'invoice_code' => $invoice_code,
			'invoice_status' => 'Belum Lunas',
			'description' => $description,
			'total_amount' => $amount,
		];

		if ($this->invoice->save($invoices) == TRUE) {

			\Midtrans\Config::$serverKey = env('midtrans.serverKey');
			\Midtrans\Config::$isProduction = env('midtrans.isProduction');
			\Midtrans\Config::$isSanitized = true;
			\Midtrans\Config::$is3ds = true;

			$params = [
				'transaction_details' => [
					'order_id' => $invoice_code,
					'gross_amount' => $amount,
				],
				'customer_details' => [
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $email,
					'phone' => $phone,
				],
			];

			$snap_token = \Midtrans\Snap::getSnapToken($params);

			$snaps = [
				'invoice_code' => $invoice_code,
				'snap_token' => $snap_token,
			];

			if ($this->snap->save($snaps) == TRUE) {

				return redirect()->to('detail/' . $invoice_code);
			} else {
				return redirect()->back();
			}
		} else {

			$this->session->setFlashdata('failed', $this->invoice->errors());

			return redirect()->back()->withInput();
		}
	}

	public function detail($invoice_code)
	{
		$builder = $this->db->table('invoices');
		$builder->where('invoices.invoice_code', $invoice_code);
		$builder->join('snaps', 'invoices.invoice_code = snaps.invoice_code');
		$query = $builder->get();

		if ($query->getNumRows() == 1) {

			$data = [
				'title' => 'My Midtrans Project',
				'invoices' => $query->getResult(),
			];

			return view('details', $data);
		} else {

			return redirect()->to('/');
		}
	}

	public function payment_notification()
	{
		require_once(VENDORPATH . 'midtrans\midtrans-php\Midtrans.php');
		\Midtrans\Config::$isProduction = env('midtrans.isProduction');
		\Midtrans\Config::$serverKey = env('midtrans.serverKey');

		$notif = new \Midtrans\Notification();

		if ($this->_signature_verification($notif) == TRUE) {

			return $this->_status_verification($notif);
		} else {

			return $this->response->setStatusCode(401);
		}
	}

	private function _signature_verification($notif)
	{
		$data = $notif->order_id;
		$data .= $notif->status_code;
		$data .= $notif->gross_amount;
		$data .= env('midtrans.serverKey');
		$key = hash('sha512', $data);

		return ($notif->signature_key == $key) ? TRUE : FALSE;
	}

	private function _status_verification($notif)
	{
		$fetch_invoices = $this->invoice->where('invoice_code', $notif->order_id)->findAll();

		if ($fetch_invoices != NULL) {

			$gross_amount = substr($notif->gross_amount, 0, -3);
			$trans_status = $notif->transaction_status;

			if ($trans_status == 'settlement') {

				foreach ($fetch_invoices as $invoice) {

					$total_amount = $invoice->total_amount;
				}

				$invoice_status = $gross_amount == $total_amount ? 'Lunas' : 'Belum Lunas';

				$invoices = [
					'invoice_status' => $invoice_status,
					'paid_amount' => $gross_amount,
				];

				if ($this->invoice->where('invoice_code', $notif->order_id)->set($invoices)->update() == TRUE) {

					return $this->_set_transaction($notif, 'Berhasil');
				} else {

					return $this->response->setStatusCode(500);
				}
			} else if ($trans_status == 'pending') {

				return $this->_set_transaction($notif, 'Menunggu Pembayaran');
			} else if ($trans_status == 'cancel') {

				$invoices = [
					'invoice_status' => 'Dibatalkan',
				];

				if ($this->invoice->where('invoice_code', $notif->order_id)->set($invoices)->update() == TRUE) {

					return $this->_set_transaction($notif, 'Dibatalkan');
				} else {

					return $this->response->setStatusCode(500);
				}
			}
		} else {

			return $this->response->setStatusCode(401);
		}
	}

	private function _set_transaction($notif, $status)
	{
		$row_check = $this->trans->where('invoice_code', $notif->order_id)->findAll();

		if ($notif->va_numbers != NULL) {

			$va_numbers = unserialize(serialize($notif->va_numbers));

			if ($va_numbers[0]->va_number != NULL) {

				$payment_code = $va_numbers[0]->va_number;
			} else {

				$payment_code = $notif->payment_code;
			}

			if ($va_numbers[0]->bank != NULL) {

				$payment_bank = strtoupper($va_numbers[0]->bank);
			} else {

				$payment_bank = strtoupper($notif->store);
			}
		} else {

			$payment_code = $notif->payment_code;
			$payment_bank = strtoupper($notif->store);
		}

		if ($row_check == NULL) {

			$transactions = [
				'invoice_code' => $notif->order_id,
				'payment_amount' => substr($notif->gross_amount, 0, -3),
				'payment_type' => $notif->payment_type,
				'payment_bank' => $payment_bank,
				'payment_code' => $payment_code,
				'transaction_time' => $notif->transaction_time,
				'transaction_code' => $notif->transaction_id,
				'transaction_status' => $status,
			];

			$result = $this->trans->save($transactions);
		} else {

			$transactions = [
				'payment_amount' => substr($notif->gross_amount, 0, -3),
				'payment_type' => $notif->payment_type,
				'payment_bank' => $payment_bank,
				'payment_code' => $payment_code,
				'transaction_time' => $notif->transaction_time,
				'transaction_code' => $notif->transaction_id,
				'transaction_status' => $status,
			];

			$result = $this->trans->where('invoice_code', $notif->order_id)->set($transactions)->update();
		}

		return $result == TRUE ? $this->response->setStatusCode(200) : $this->response->setStatusCode(500);
	}
}
