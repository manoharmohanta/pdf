<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  require(APPPATH . 'third_party/fpdf/fpdf.php');

  class Mypdf extends FPDF {
  
    // Page Header
    public function header(){
        $image1 = 'asset/sunglade.png';
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        $this->Cell( 40, 40, $this->Image($image1, $this->Getx(), $this->Gety(), 56), 0, 0, 'L', false );
        $this->Ln(16);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-26);
        // Arial italic 8
        $this->SetFont('Arial','',12);
        // Page number
        $this->SetTextColor(59, 59, 109);
        $this->Cell(0,10, 'Sunglade Digital Solutions',0,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0,10, 'Kukatpally, Hyderabad, Telangana 500055',0,0,'C');$this->Ln(4);
        $this->Cell(0,10, 'Tel: +91-7989368047 | Website: sunglade.in ',0,0,'C');$this->Ln(4);
        $this->Cell(0,10, 'SDS Career Check: sunglade.in/career-check | Email: careers@sunglade.in ',0,0,'C');$this->Ln(4);
        $this->SetFont('Arial','I',6);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
  
      public function getInstance(){
          return new Mypdf('P','mm','A4');
      }
  }
  // class Mypdf{
  
    // public function __construct()
    // {
    //     require_once APPPATH. 'third_party/fpdf/fpdf.php';
    //     $pdf = new FPDF('P','mm','A4');

    //     $pdf->AddPage();
    //     // $pdf->SetFont('Work Sans','B',16);

    //     $CI = get_instance();
    //     $CI->fpdf=$pdf;
    // }
    // function Header()
    // {
    //     // Logo
    //     // $this->Image('logo.png',10,6,30);
    //     // Arial bold 15
    //     $this->SetFont('Arial','B',15);
    //     // Move to the right
    //     $this->Cell(80);
    //     // Title
    //     $this->Cell(30,10,'Title',1,0,'C');
    //     // Line break
    //     $this->Ln(20);
    // }

    // // Page footer
    // function Footer()
    // {
    //     // Position at 1.5 cm from bottom
    //     $this->SetY(-15);
    //     // Arial italic 8
    //     $this->SetFont('Arial','I',8);
    //     // Page number
    //     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    // }
// }
  
/* End of file Pdf.php */