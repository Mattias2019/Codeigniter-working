<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// This is extended library file for core pagination file.

class MY_Pagination extends CI_Pagination

{

	function __construct(array $params = array())

	{

		parent::__construct($params);

	}

	

	function initialize(array $params = array())

	{

		parent::initialize($params);

	}

	

	function create_links($use_offsets = true,$type='')

	{

		if ($use_offsets)

			return parent::create_links();
			
		elseif($type == 'project')
			return $this->create_links2();

		else

			return $this->create_links_without_offsets();

	}

	

	function create_links_without_offsets()

	{

		// Check total rows and per page count is zero

		if ($this->total_rows == 0 OR $this->per_page == 0)

		{

		   return '';

		}



		// Calculate the total number of pages

		$num_pages = ceil($this->total_rows / $this->per_page);
		
		//echo $this->total_rows.",".$this->per_page;exit;

		//No. of pages is one

		if ($num_pages == 1)

		{

			return '';

		}

		

		// Get current page number		

		$CI =& get_instance();	

		if ($CI->uri->segment($this->uri_segment) != 0)

		{

			$this->cur_page = $CI->uri->segment($this->uri_segment);

			$this->cur_page = (int) $this->cur_page;

		}


		$this->num_links = (int)$this->num_links;

  		if ($this->num_links < 1)

		{

			show_error('Your number of links must be a positive number.');

		}

				

		if ( ! is_numeric($this->cur_page))

		{

			$this->cur_page = 1;

		}


		if ($this->cur_page < 1) {

			$this->cur_page = 1;
 		 } 


		//If page number exceeds the limit,displays last page.

		if ($this->cur_page > $num_pages)

		{

			$this->cur_page = $num_pages;

		}

		

		$uri_page_number = $this->cur_page;
		
		// Compute the start and end page

		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;

		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;



		// Add a trailing slash to the base URL if needed

		//$this->base_url = rtrim($this->base_url, '/') .'/';

		$output = '';



		// Represent the "First" link
		$output .= $this->first_tag_open.'<a href="#" data-page="1">'.$this->first_link.'</a>'.$this->first_tag_close;

		// Represent the "previous" link
		$i = $uri_page_number - 1;
		if ($i < 1) $i = 1;
		$output .= $this->prev_tag_open.'<a href="#" data-page="'.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;

		// Represents the digit links
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = $loop;

			if ($i >= 1)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open.'<a href="#" data-page="'.$n.'">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}

		// Represent the "next" link
		$i = $this->cur_page + 1;
		if ($i > $num_pages) $i = $num_pages;
		$output .= $this->next_tag_open.'<a href="#" data-page="'.$i.'">'.$this->next_link.'</a>'.$this->next_tag_close;

		// Represent the "Last" link
		$i = $num_pages;
		$output .= $this->last_tag_open.'<a href="#" data-page="'.$i.'">'.$this->last_link.'</a>'.$this->last_tag_close;


		// Eliminating double slashes
		$output = preg_replace("#([^:])//+#", "\\1/", $output);



		// Add the wrapper HTML if exists

		$output = $this->full_tag_open.$output.$this->full_tag_close;

		

		return $output;	

	}
	
	function create_links2()
	{
		
		// Check values of total rows and per page is zero
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// No. of pages is one
		if ($num_pages == 1)
		{
			return '';
		}
		
		// Determine the current page number.		
		$CI =& get_instance();	
		if ($CI->uri->segment($this->uri_segment) != 0)
		{
			$this->cur_page = $CI->uri->segment($this->uri_segment);

			$this->cur_page = (int) $this->cur_page;
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
				
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 1;
		}
		
		if ($this->cur_page < 1) {
			$this->cur_page = 1;
		} 

		//If page number exceeds the limit,displays last page.
		if ($this->cur_page > $num_pages)
		{
			$this->cur_page = $num_pages;
		}
		
		$uri_page_number = $this->cur_page;
		//$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		
		// Compute the start and end page numbers
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Add a trailing slash to the base URL if needed
		$this->base_url = rtrim($this->base_url, '/') .'/';

		$output = '';

		// Represent the "First" link
		if  ($this->cur_page > $this->num_links)
		{
			$output .= $this->first_tag_open.'<a href="'.$this->base_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Represent the "previous" link
		if  ($this->cur_page > 1)
		{

			
			$i = $uri_page_number - 1;
			if ($i == 1) $i = '';
			$output .= $this->prev_tag_open.'<a href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}

	
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = $loop;
					
			if ($i >= 1)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; 
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open.'<a href="'.$this->base_url.$n.'">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}

		// Represent the "next" link
		if ($this->cur_page < $num_pages)
		{
			$output .= $this->next_tag_open.'<a href="'.$this->base_url.($this->cur_page + 1).'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Represent the "Last" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = $num_pages;
			$output .= $this->last_tag_open.'<a href="'.$this->base_url.$i.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Eliminating double slashes
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		return $output;	
	}
}
// End Class
?>