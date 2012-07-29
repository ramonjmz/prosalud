<?php
class Report_Page
{
	protected $_page;
	protected $_yPosition;
	protected $_leftMargin;
	protected $_pageWidth;
	protected $_pageHeight;
	protected $_normalFont;
	protected $_boldFont;
	protected $_year;
	protected $_headTitle;
	protected $_introText;
	protected $_graphData;
	public function __construct()
	{
		$this->_page = new Zend_Pdf_Page(
		Zend_Pdf_Page::SIZE_A4);
		$this->_yPosition = 60;
		$this->_leftMargin = 50;
		$this->_pageHeight = $this->_page->getHeight();
		$this->_pageWidth = $this->_page->getWidth();
		$this->_normalFont =
		Zend_Pdf_Font::fontWithName(
		Zend_Pdf_Font::FONT_HELVETICA);
		$this->_boldFont =
		Zend_Pdf_Font::fontWithName(
		Zend_Pdf_Font::FONT_HELVETICA_BOLD);
	}
}