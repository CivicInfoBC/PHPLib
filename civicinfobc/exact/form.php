<?php


	namespace CivicInfoBC\EXact;
	
	
	/**
	 *	Encapsulates the HTML form that must be output
	 *	to direct users to pay using E-Xact hosted
	 *	checkout.
	 */
	class Form {
		
		
		private $form;
		private $arr=array(
			'currency_code' => 'CAD'
		);
		
		
		/**
		 *	The hosted checkout object associated with
		 *	this instance.
		 */
		protected $hco;
		
		
		/**
		 *	\em true if the form should be in test mode,
		 *	\em false otherwise.
		 *
		 *	Defaults to \em false.
		 */
		public $test=false;
		/**
		 *	\em true if a relay response is required,
		 *	\em false otherwise.
		 *
		 *	Defaults to \em true.
		 */
		public $relay_response=true;
		/**
		 *	The label the submit button will have.
		 *
		 *	Defaults to \"Pay Online\".
		 */
		public $submit_label='Pay Online';
		
		
		/**
		 *	Creates a new form.
		 *
		 *	\param [in] $hco
		 *		The hosted checkout object with which
		 *		this form shall be associated.
		 */
		public function __construct (HostedCheckout $hco) {
		
			$this->hco=$hco;
		
		}
		
		
		private static function get_material () {
		
			$retr='';
			foreach (func_get_args() as $arg) {
			
				if ($retr!=='') $retr.='^';
				
				$retr.=$arg;
			
			}
			
			return $retr;
		
		}
		
		
		private static function flt ($flt) {
		
			return sprintf('%.2f',$flt);
		
		}
		
		
		private function get_hmac ($random, $time) {
		
			return hash_hmac(
				'MD5',
				self::get_material(
					$this->hco->login_terminal,
					$random,
					$time,
					self::flt($this->amount),
					$this->currency_code
				),
				$this->hco->transaction_key
			);
		
		}
		
		
		private function get_form () {
		
			$doc=new \DOMDocument('1.0','utf-8');
			
			$doc->appendChild($this->form=$doc->createElement('form'));
			$this->form->setAttribute('action',$this->hco->form_url);
			$this->form->setAttribute('method','POST');
		
		}
		
		
		protected function Add ($key, $value) {
		
			$this->form->appendChild($e=$this->form->ownerDocument->createElement('input'));
			$e->setAttribute('name',$key);
			$e->setAttribute(
				'value',
				is_float($value)
					?	self::flt($value)
					:	(
							is_bool($value)
								?	($value ? 'TRUE' : 'FALSE')
								:	$value
						)
			);
			$e->setAttribute('type','hidden');
		
		}
		
		
		protected function AddLineItem () {
		
			$line_item='';
			foreach (func_get_args() as $arg) $line_item.=(
				is_float($arg) ? self::flt($arg) : $arg
			).'<|>';
			
			$this->Add('x_line_item',$line_item);
		
		}
		
		
		private function do_output () {
		
			foreach ($this->arr as $key=>$value) $this->Add('x_'.$key,$value);
		
		}
		
		
		private function add_submit () {
		
			$this->form->appendChild($e=$this->form->ownerDocument->createElement('input'));
			$e->setAttribute('value',$this->submit_label);
			$e->setAttribute('type','submit');
		
		}
		
		
		/**
		 *	Retrieves a DOMElement which is the root of an
		 *	HTML form element which encapsulates all necessary
		 *	elements to direct users to E-Xact hosted
		 *	checkout.
		 *
		 *	\return
		 *		A DOMElement.
		 */
		public function Get () {
		
			//	Not sure why these values are used,
			//	scraped from the old ASP function
			$random=mt_rand(0,99999)+123456;
			
			//	Current time
			$time=time();
			
			//	Create the form
			$this->get_form();
			
			//	Append eleemnts to the form
			$this->Add(
				'x_test_request',
				$this->test
			);
			$this->Add(
				'x_relay_response',
				$this->relay_response
			);
			$this->Add(
				'x_login',
				$this->hco->login_terminal
			);
			$this->Add(
				'x_fp_sequence',
				$random
			);
			$this->Add(
				'x_fp_timestamp',
				$time
			);
			$this->Add(
				'x_fp_hash',
				$this->get_hmac($random,$time)
			);
			$this->Add(
				'x_show_form',
				'PAYMENT_FORM'
			);
			
			$this->do_output();
			
			$this->add_submit();
			
			//	Return form
			return $this->form;
		
		}
		
		
		public function __isset ($key) {
		
			return isset($this->arr[$key]);
		
		}
		
		
		public function __get ($key) {
		
			if (isset($this->arr[$key])) return $this->arr[$key];
			
			return null;
		
		}
		
		
		public function __unset ($key) {
		
			unset($this->arr[$key]);
		
		}
		
		
		public function __set ($key, $value) {
		
			if (is_null($value)) unset($this->arr[$key]);
			else $this->arr[$key]=$value;
		
		}
		
		
		/**
		 *	Obtains HTML which represents this form.
		 *
		 *	\return
		 *		A string containing HTML.
		 */
		public function __toString () {
		
			$form=$this->Get();
			
			return $form->ownerDocument->saveHTML($form);
		
		}
	
	
	}


?>