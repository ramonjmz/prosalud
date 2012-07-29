<?php
class Report_Document
{
	protected $_pdf;
	public function __construct()
	{
		$this->_pdf = new Zend_Pdf();
		$this->_pdf->properties['Title'] =
'Yearly Statistics Report';
		$this->_pdf->properties['Author'] =
'Places to take the kids';
	}
	public function addPage(Report_Page $page)
	{
		$this->_pdf->pages[] = $page->render();
	}
	public function getDocument()
	{
		return $this->_pdf;
	}
}