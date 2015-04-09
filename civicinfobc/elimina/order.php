<?php


	namespace CivicInfoBC\EliMina;
	
	
	class Order {
	
	
		private static $map;
		private static $max=1000;
		private static $containers;
		private static $discounts;
		
		
		private static function measure ($str) {
		
			return new \CivicInfoBC\Measure($str);
		
		}
		
		
		/**
		 *	\cond
		 */
		
		
		public static function Init () {
		
			self::$map=array(
				'minute_taking' => new Item(
					'Mina\'s Guide to Minute Taking',
					25.0,
					self::measure('0.183kg'),
					self::measure('0.25 inches'),
					self::measure('7 inches'),
					self::measure('9 inches')
				),
				'boardroom_problems' => new Item(
					'101 Board Room Problems',
					30.0,
					self::measure('0.341kg'),
					self::measure('0.5 inches'),
					self::measure('7 inches'),
					self::measure('9 inches')
				),
				'minute_taking_ebook' => new Item(
					'Mina\'s Guide to Minute Taking (E-Book)',
					25.0,
					self::measure('0kg'),
					self::measure('0 inches'),
					self::measure('0 inches'),
					self::measure('0 inches')
				),
				'boardroom_problems_ebook' => new Item(
					'101 Board Room Problems (E-Book)',
					30.0,
					self::measure('0kg'),
					self::measure('0 inches'),
					self::measure('0 inches'),
					self::measure('0 inches')
				),
				'complete_handbook_ebook' => new Item(
					'The Complete Handbook of Business Meetings',
					35.0,
					self::measure('0kg'),
					self::measure('0 inches'),
					self::measure('0 inches'),
					self::measure('0 inches')
				),
				'meetings_sourcebook_ebook' => new Item(
					'The Business Meetings Sourcebook',
					80.0,
					self::measure('0kg'),
					self::measure('0 inches'),
					self::measure('0 inches'),
					self::measure('0 inches')
				)
			);
			
			self::$containers=array(
				new Container(
					'#2 Envelope',
					1.99,
					self::measure('1 inch'),
					self::measure('8.5 inches'),
					self::measure('11 inches')
				),
				new Container(
					'Small Mailing Box',
					3.99,
					self::measure('2.5 inches'),
					self::measure('11.25 inches'),
					self::measure('9 inches')
				),
				new Container(
					'Medium Mailing Box',
					4.99,
					self::measure('5.25 inches'),
					self::measure('12.25 inches'),
					self::measure('9.25 inches')
				),
				new Container(
					'Large Mailing Box',
					5.49,
					self::measure('3.75 inches'),
					self::measure('15 inches'),
					self::measure('12 inches')
				),
				new Container(
					'Extra Large Mailing Box',
					6.49,
					self::measure('8.25 inches'),
					self::measure('15.75 inches'),
					self::measure('12 inches')
				)
			);
			
			self::$discounts=array(
				new QuantityDiscount(6,9,0.1),
				new QuantityDiscount(10,19,0.2),
				new QuantityDiscount(20,29,0.3),
				new QuantityDiscount(30,49,0.4),
				new QuantityDiscount(50,null,0.5)
			);
		
		}
		
		
		/**
		 *	\endcond
		 */
		
		
		private $order=array();
		private $packing=null;
		
		
		/**
		 *	Creates a new Order.
		 *
		 *	\param [in] $obj
		 *		An object which maps keys to values, where the
		 *		keys specify the item, and the values specify
		 *		the number ordered.
		 */
		public function __construct ($obj) {
		
			$kv=new \CivicInfoBC\KeyValueWrapper($obj);
			
			$items=0;
			foreach (self::$map as $key=>$item) {
			
				if (!isset($kv->$key)) continue;
				
				$curr=new ItemOrder(
					$item,
					\CivicInfoBC\Convert::ToIntegerOrThrow($kv->$key)
				);
				if ($curr->quantity===0) continue;
				$items+=$curr->quantity;
				
				$this->order[]=$curr;
			
			}
			
			if ($items>self::$max) throw new \Exception(
				sprintf(
					'%s items is greater than the maximum of %s',
					$items,
					self::$max
				)
			);
		
		}
		
		
		/**
		 *	Retrieves an array of ItemOrder objects representing
		 *	the order.
		 *
		 *	\return
		 *		An array of ItemOrder objects.
		 */
		public function Order () {
		
			return $this->order;
		
		}
		
		
		/**
		 *	Attempts to pack the order in one or more of the
		 *	available containers.
		 *
		 *	\return
		 *		An array of PackResult objects specifying
		 *		how the order was packed.
		 */
		public function Pack () {
		
			if (is_null($this->packing)) {
				
				$ebooks=true;
				foreach ($this->order as $item) {
					
					if ($item->item->weight->quantity!=0) {
						
						$ebook=false;
						break;
						
					}
					
				}
				
				if ($ebooks) return $this->packing=array();
			
				$packer=new Packer(self::$containers);
				$this->packing=$packer->Pack($this->order);
			
			}
			
			return $this->packing;
		
		}
		
		
		private static function to_cost ($flt) {
		
			return round($flt,2);
		
		}
		
		
		private function get_shipping (\CivicInfoBC\CanadaPost\Client $client=null, \CivicInfoBC\CanadaPost\GetRatesRequest $request=null) {
		
			if (is_null($client) || is_null($request)) return 0.0;
			
			$retr=0.0;
			foreach ($this->Pack() as $packed) {
			
				$request->parcel=$packed->Parcel();
				$response=$client->Execute($request);
				if (count($response)===0) throw new \Exception(
					'Canada Post API didn\'t return any quotes'
				);
				$retr+=$response[0]->price_details->due;
				$retr+=$packed->container->cost;
			
			}
			
			return self::to_cost($retr);
		
		}
		
		
		public function Pricing ($tax_rate, \CivicInfoBC\CanadaPost\Client $client=null, \CivicInfoBC\CanadaPost\GetRatesRequest $request=null) {
		
			$retr=new Pricing();
			$retr->tax_rate=$tax_rate;
			
			foreach ($this->order as $item) $retr->subtotal+=self::to_cost($item->item->cost*$item->quantity);
			
			$retr->shipping=$this->get_shipping($client,is_null($request) ? null : clone $request);
			
			foreach (self::$discounts as $discount) $discount->Apply($retr,$this->order);
			
			return $retr;
		
		}
	
	
	}
	
	
	Order::Init();


?>