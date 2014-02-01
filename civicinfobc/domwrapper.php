<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	Provides a wrapper for the PHP built-in
	 *	DOMNode class.  Allows iteration over the
	 *	children of a DOMNode with filtering, easy
	 *	access to children with a certain tag name,
	 *	and easy access to that DOMNode's attributes.
	 */
	class DOMWrapper implements \arrayaccess, \Iterator {
	
	
		private $root;
		private $curr;
		private $filter;
	
	
		/**
		 *	Creates a new DOMWrapper.
		 *
		 *	\param [in] $node
		 *		The DOMNode to wrap.
		 *	\param [in] $filter
		 *		Optional.  A filter to apply when
		 *		iterating over the children of \em node.
		 *		May be boolean or a string.  If boolean
		 *		\em true means that all children which
		 *		are not DOMElements will be automatically
		 *		skipped.  If \em false all DOMNodes which
		 *		are children of \em node will be iterated.
		 *		If a string, all children which are not
		 *		DOMElements will automatically be skipped,
		 *		and in addition all DOMElements which do not
		 *		have the tag name specified by the filter
		 *		will be skipped.  Defaults to \em true.
		 */
		public function __construct (\DOMNode $node, $filter=true) {
		
			$this->root=$node;
			$this->filter=is_bool($filter) ? $filter : String::ToLower($filter);
			
			$this->rewind();
		
		}
		
		
		public function current () {
		
			return $this->curr;
		
		}
		
		
		public function key () {
		
			return null;
		
		}


		private function next_element () {
		
			while (!(
				is_null($this->curr) ||
				($this->curr instanceof \DOMElement)
			)) $this->curr=$this->curr->nextSibling;
		
		}
		
		
		private function skip () {
		
			if (is_null($this->filter)) return;
			
			if (is_bool($this->filter)) {
			
				if ($this->filter) $this->next_element();
				
				return;
			
			}
			
			$first=true;
			do {
			
				if ($first) $first=false;
				else $this->curr=$this->curr->nextSibling;
				
				$this->next_element();
			
			} while (!(
				is_null($this->curr) ||
				String::Equals(
					String::ToLower($this->curr->tagName),
					$this->filter
				)
			));
		
		}
		
		
		public function next () {
		
			$this->curr=$this->curr->nextSibling;
			
			$this->skip();
		
		}

		
		public function rewind () {
		
			$this->curr=$this->root->firstChild;
			
			$this->skip();
		
		}
		
		
		public function valid () {
		
			return !is_null($this->curr);
		
		}
		
		
		/**
		 *	Retrieves an attribute of the wrapped node.
		 *
		 *	If the attribute is not present, some default
		 *	value is returned instead.
		 *
		 *	\param [in] $name
		 *		The name of the attribute to retrieve.
		 *	\param [in] $default
		 *		The value to return if an attribute named
		 *		\em name does not exist.  Defaults to
		 *		\em null.
		 *
		 *	\return
		 *		The text value of the attribute specified
		 *		by \em name if it exists, \em default otherwise.
		 */
		public function GetAttribute ($name, $default=null) {
		
			return is_null($node=$this->root->attributes->getNamedItem(
				String::ToLower($name)
			)) ? null : $node->nodeValue;
		
		}
		
		
		/**
		 *	Determines whether or not the wrapped node
		 *	has a certain attribute.
		 *
		 *	\param [in] $offset
		 *		The name of the attribute to check.
		 *
		 *	\return
		 *		\em true if the wrapped node has the
		 *		attribute \em offset, \em false otherwise.
		 */
		public function offsetExists ($offset) {
		
			return !is_null($this->GetAttribute($offset));
		
		}
		
		
		/**
		 *	Retrieves an attribute of the wrapped node.
		 *
		 *	\param [in] $offset
		 *		The name of the attribute to retrieve.
		 *
		 *	\return
		 *		The text value of the attribute specified
		 *		by \em offset if it exists, \em null
		 *		otherwise.
		 */
		public function offsetGet ($offset) {
		
			if (is_null($retr=$this->GetAttribute($offset))) throw new \Exception(
				sprintf(
					'No attribute with name "%s"',
					$offset
				)
			);
			
			return $retr;
		
		}
		
		
		public function offsetSet ($offset, $value) {	}
		
		
		public function offsetUnset ($offset) {	}
		
		
		/**
		 *	Retrieves the first child of the wrapped node
		 *	with a certain tag name.
		 *
		 *	If no such node exists, a default value is
		 *	returned.
		 *
		 *	\param [in] $name
		 *		The tag name.
		 *	\param [in] $default
		 *		The default value to return if no child
		 *		node with tag name \em name exists.  Defaults
		 *		to \em null.
		 *
		 *	\return
		 *		A DOMNode object which represents the first
		 *		child of the wrapped node with the tag name
		 *		\em name, or \em default if no such node
		 *		exists.
		 */
		public function GetChild ($name, $default=null) {
		
			$children=new DOMWrapper($this->root,$name);
			
			foreach ($children as $child) return $child;
			
			return $default;
		
		}
		
		
		/**
		 *	Retrieves the first child of the wrapped node
		 *	with a certain tag name.
		 *
		 *	If no such node exists, an exception is thrown.
		 *
		 *	\param [in] $name
		 *		The tag name.
		 *
		 *	\return
		 *		A DOMNode object which represents the first
		 *		child of the wrapped node with the tag name
		 *		\em name.
		 */
		public function __get ($name) {
		
			if (is_null($retr=$this->GetChild($name))) throw new \Exception(
				sprintf(
					'No child node with tag name "%s"',
					$name
				)
			);
			
			return $retr;
		
		}
		
		
		/**
		 *	Determines whether the wrapped node has a child
		 *	with a given tag name.
		 *
		 *	\param [in] $name
		 *		The tag name.
		 *
		 *	\return
		 *		\em true if the wrapped node has a child with
		 *		the tag name \em name, \em false otherwise.
		 */
		public function __isset ($name) {
		
			return !is_null($this->GetChild($name));
		
		}
	
	
	}


?>