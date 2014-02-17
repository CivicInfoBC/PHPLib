<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates an order placed on the
	 *	Eli Mina book sale form.
	 */
	class EliMina {
	
	
		private static $map;
		private static $max=60;
		private static $containers;
		
		
		private static function measure ($str) {
		
			return new \CivicInfoBC\Measure($str);
		
		}
		
		
		private static function dimensions ($a, $b, $c) {
		
			if (!is_null($a)) $a=self::measure($a);
			if (!is_null($b)) $b=self::measure($b);
			if (!is_null($c)) $c=self::measure($c);
		
			return new \CivicInfoBC\CanadaPost\Dimensions($a,$b,$c);
		
		}
		
		
		/**
		 *	\cond
		 */
		 
		 
		public static function Init () {
		
			self::$map=array(
				'minute_taking' => new EliMina\Item(
					'Mina\'s Guide to Minute Taking',
					25.0,
					self::measure('0.183kg'),
					self::measure('0.25 inches')
				),
				'boardroom_problems' => new EliMina\Item(
					'101 Board Room Problems',
					30.0,
					self::measure('0.341kg'),
					self::measure('0.5 inches')
				)
			);
			
			self::$containers=array(
				new EliMina\Container(
					'#2 Envelope',
					1.99,
					1,
					self::dimensions(
						null,
						'8.5 inches',
						'11 inches'
					)
				),
				new EliMina\Container(
					'Small Mailing Box',
					3.99,
					null,
					self::dimensions(
						'11.25 inches',
						'9 inches',
						'2.5 inches'
					),
					self::measure('2.5 inches')
				),
				new EliMina\Container(
					'Medium Mailing Box',
					4.99,
					null,
					self::dimensions(
						'12.25 inches',
						'9.25 inches',
						'5.25 inches'
					),
					self::measure('5.25 inches')
				),
				new EliMina\Container(
					'Large Mailing Box',
					5.49,
					null,
					self::dimensions(
						'15 inches',
						'12 inches',
						'3.75 inches'
					),
					self::measure('7.5 inches')
				),
				new EliMina\Container(
					'Extra Large Mailing Box',
					6.49,
					null,
					self::dimensions(
						'15.75 inches',
						'12 inches',
						'8.5 inches'
					),
					self::measure('17 inches')
				)
			);
		
		}
		
		
		/**
		 *	\endcond
		 */
		 
		
		private $kv;
		private $order;
		private $details;
		
		
		public function __construct ($kv) {
		
			$this->kv=new \CivicInfoBC\KeyValueWrapper($kv);
		
		}
		
		
		/**
		 *	Retrieves an array of EliMina\\ItemOrder
		 *	objects representing this order.
		 *
		 *	\return
		 *		An array of EliMina\\ItemOrder objects
		 *		representing this order.
		 */
		public function GetOrder () {
		
			if (is_null($this->order)) {
			
				$this->order=array();
				foreach (self::$map as $key=>$value) {
				
					if (isset($this->kv->$key)) $this->order[]=new EliMina\ItemOrder(
						$value,
						\CivicInfoBC\Convert::ToIntegerOrThrow($this->kv->$key)
					);
				
				}
			
			}
			
			return $this->order;
		
		}
		
		
		private static function too_many () {
		
			throw new \Exception(
				sprintf(
					'More than %s items',
					self::$max
				)
			);
		
		}
		
		
		/**
		 *	Attempts to pack this order in one of
		 *	the available containers.
		 *
		 *	\return
		 *		An EliMina\\PackingDetails object
		 *		representing the result of packing
		 *		this order.
		 */
		public function Pack () {
		
			if (is_null($this->details)) {
		
				$order=$this->GetOrder();
				
				//	Calculate the weight of the order,
				//	how many items are in it, and it's
				//	total height
				
				$weight=self::measure('0kg');
				$total=0;
				foreach ($order as $item) {
				
					if ($item->quantity>self::$max) self::too_many();
					$total+=$item->quantity;
					
					$weight=$weight->Add(
						$item->item->weight->Multiply(
							$item->quantity
						)
					);
				
				}
				
				if ($total>self::$max) self::too_many();
				
				//	Try and find a container that will
				//	fit this order
				$container=null;
				foreach (self::$containers as $c) {
				
					if (!is_null($container=$c->Get($order))) break;
				
				}
				
				if (is_null($container)) throw new \Exception(
					'No container can hold this order'
				);
				
				$this->details=new EliMina\PackingDetails(
					$total,
					$weight,
					$container
				);
				
			}
			
			return $this->details;
		
		}
		
		
		public function GetRatesRequest () {
		
			return $this->Pack()->GetRatesRequest();
		
		}
		
		
		private static function to_cost ($flt) {
		
			return round($flt,2);
		
		}
		
		
		private function get_shipping (
			\CivicInfoBC\CanadaPost\Client $client=null,
			\CivicInfoBC\CanadaPost\GetRatesRequest $request=null
		) {
		
			if (is_null($client) || is_null($request)) return 0.0;
			
			$response=$client->Execute($request);
			
			if (count($response)===0) throw new \Exception(
				'Canada Post API didn\'t return any quotes'
			);

			return self::to_cost(
				$response[0]->price_details->due+$this->Pack()->container->cost
			);
		
		}
		
		
		/**
		 *	Gets the pricing for this order.
		 *
		 *	\param [in] $tax_rate
		 *		The sales tax rate.
		 *	\param [in] $client
		 *		A Canada Post XML API client.  Optional.
		 *		Defaults to \em null.  If \em null shipping
		 *		pricing will not be obtained.
		 *	\param [in] $request
		 *		A GetRatesRequest object encapsulating the
		 *		details of shipping this order.  Optional.
		 *		Defaults to \em null.  If \em null shipping
		 *		pricing will not be obtained.
		 *
		 *	\return
		 *		An EliMina\\Pricing object containing details
		 *		of the pricing of this order.
		 */
		public function GetPricing (
			$tax_rate,
			\CivicInfoBC\CanadaPost\Client $client=null,
			\CivicInfoBC\CanadaPost\GetRatesRequest $request=null
		) {
		
			$retr=new EliMina\Pricing();
			if ($this->Pack()->total===0) return $retr;
			$retr->shipping=$this->get_shipping($client,$request);
			$retr->subtotal=0.0;
			foreach ($this->GetOrder() as $item) $retr->subtotal+=self::to_cost(
				$item->item->cost*$item->quantity
			);
			$retr->tax=self::to_cost(
				($retr->shipping+$retr->subtotal)*$tax_rate
			);
			$retr->total=self::to_cost(
				$retr->shipping+$retr->subtotal+$retr->tax
			);
			
			return $retr;
		
		}
	
	
	}
	
	
	EliMina::Init();


?>