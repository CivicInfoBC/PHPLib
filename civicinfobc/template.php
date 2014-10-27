<?php


	namespace CivicInfoBC;
	
	
	/**
	 *	The base class for the Template class.
	 *
	 *	Since code on templates runs in the context
	 *	of instances of the Template class, the
	 *	base class serves to hide all the private
	 *	member variables.
	 */
	abstract class TemplateBase extends Object implements Renderable {
	
	
		private $dir;
		private $files=array();
		
		
		protected function __construct ($dir='./') {
		
			$this->dir=Regex::Replace(
				'/(?<!\\/)$/u',
				'/',
				$dir
			);
		
		}
		
		
		protected abstract function render_file ($file);
		
		
		private function make_file ($file) {
		
			return $this->dir.Regex::Replace(
				'/^[\\\\\\/]/u',
				'',
				$file
			);
		
		}
		
		
		private function next_impl () {
		
			//	Stop rendering if this is the last
			//	template
			if (count($this->files)===0) return false;
			
			$next=array_shift($this->files);
			
			if ($next instanceof Renderable) {
			
				$next->Render();
				
				return true;
			
			}
			
			$file=$this->make_file($next);
			
			//	If the template file exists, pull
			//	it in
			if (file_exists($file)) $this->render_file($file);
			//	Otherwise throw an exception
			else throw new \Exception(
				sprintf(
					'No file %s',
					$file
				)
			);
			
			return true;
		
		}
		
		
		/**
		 *	Renders the next template in the chain, but does
		 *	not implicitly continue rendering templates in the
		 *	chain thereafter.
		 */
		public function NextOne () {
		
			$this->next_impl();
		
		}
		
		
		/**
		 *	Renders the next template in the chain.
		 *
		 *	May be called from within a template to
		 *	start rendering the next template before
		 *	that template has finished rendering, for
		 *	example if the inner template should make
		 *	up the body of a page.
		 */
		public function Next () {
		
			while ($this->next_impl());
		
		}
		
		
		private function add_array ($arr) {
		
			foreach ($arr as $x) if (is_array($x)) $this->add_array($x);
			else $this->files[]=$x;
		
		}
		
		
		/**
		 *	Adds a file or files to the template chain.
		 *
		 *	Any number of arguments may be passed, they
		 *	will all be added.  If any of the arguments
		 *	is an array, each element of that array will
		 *	be added recursively.
		 */
		public function Add () {
		
			$this->add_array(func_get_args());
		
		}
		
		
		/**
		 *	Renders the template chain.
		 *
		 *	Any number of arguments may be passed, they
		 *	will be added before rendering.  If any of
		 *	the arguments is an array, each element of
		 *	that array will be added recursively.
		 */
		public function Render () {
		
			//	Add the file(s) to the chain
			$this->add_array(func_get_args());
			
			//	Begin
			$this->Next();
		
		}
		
		
		/**
		 *	Renders the template chain and returns it as
		 *	a string.
		 *
		 *	Any number of arguments may be passed, they
		 *	will be added before rendering.  If any of
		 *	the arguments is an array, each element of
		 *	that array will be added recursively.
		 */
		public function Get () {
		
			ob_start();
			
			try {
			
				$this->Render(func_get_args());
				
			} catch (\Exception $e) {
			
				ob_end_clean();
				
				throw $e;
			
			}
			
			$retr=ob_get_contents();
			
			ob_end_clean();
			
			return $retr;
		
		}
	
	
	}
	
	
	/**
	 *	A template class.
	 *
	 *	An arbitrary number of files may be added
	 *	to the template.  When it is rendered each
	 *	of those files will be included in turn.
	 *
	 *	Arbitrary member variables of the template
	 *	may be set, they can be retrieved through
	 *	the \em this variable within the included
	 *	files.
	 */
	class Template extends TemplateBase {
	
	
		/**
		 *	Creates a new template.
		 *
		 *	\param [in] $dir
		 *		The directory from which to pull
		 *		templates.  Defaults to the current
		 *		directory.
		 */
		public function __construct ($dir='./') {
		
			parent::__construct($dir);
		
		}
		
		
		protected function render_file ($file) {
		
			include($file);
		
		}
	
	
	}


?>