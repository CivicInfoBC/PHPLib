<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Encapsulates the functionality needed to
	 *	drive the Eli Mina book sale form.
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
					self::measure('0.183kg'),
					self::measure('0.25 inches')
				),
				'boardroom_problems' => new EliMina\Item(
					'101 Board Room Problems',
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
		 
		 
		/**
		 *	Retrieves an array of EliMina\\ItemOrder
		 *	objects representing a certain order.
		 *
		 *	\param [in] $kv
		 *		An object which maps keys to values
		 *		where the keys given the encoded
		 *		titles of the books, and the values
		 *		give the quantity of each book.
		 *
		 *	\return
		 *		An array of EliMina\\ItemOrder objects
		 *		representing the order encapsulated by
		 *		\em kv.
		 */
		public static function GetOrder ($kv) {
		
			$kv=new \CivicInfoBC\KeyValueWrapper($kv);
			
			$retr=array();
			foreach (self::$map as $key=>$value) {
			
				if (isset($kv->$key)) $retr[]=new EliMina\ItemOrder(
					$value,
					Convert::ToIntegerOrThrow($kv->$key)
				);
			
			}
			
			return $retr;
		
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
		 *	Attempts to pack a certain order in one of
		 *	the available containers.
		 *
		 *	\param [in] $order
		 *		An array of EliMina\\ItemOrder objects
		 *		representing the order to pack.
		 *
		 *	\return
		 *		An EliMina\\PackingDetails object
		 *		representing the result of packing
		 *		\em order.
		 */
		public static function Pack ($order) {
		
			$order=ArrayUtil::Coalesce($order);
		
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
			
			return new EliMina\PackingDetails(
				$total,
				$weight,
				$container
			);
		
		}
	
	
	}
	
	
	EliMina::Init();


?>