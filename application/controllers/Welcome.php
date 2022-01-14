<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public $CI = NULL;

	public function __construct() {
        parent::__construct();
		$this->CI = & get_instance();
        $this->load->library("Mypdf");
    }

	public function index(){
		$this->load->view('template/pages/login/login');
	}

	public function register(){
		$this->load->view('template/pages/login/register');
	}

	public function forgot(){
		$this->load->view('template/pages/login/forgot');
	}

	public function recovery(){
		$encrypt_value = $this->my_simple_crypt($this->uri->segment(3), 'd');

		$this->db->where('user_id',$encrypt_value);
		$this->db->where('status',1);
        $this->db->limit(1);
        $check = $this->db->get('user');

		if($check->num_rows() > 0){
			$response['response'] = array(
				'status'=> 1,
				'msg'=> 'If your email id is valid',
			);
		}else{
			//Invalid URL
			$response['response'] = array(
				'status'=> 0,
				'msg'=> 'Invalid URL.',
				'url' => base_url(),
			);
		}
		$this->load->view('template/pages/login/reset',$response);
	}

	public function dashboard(){
		if($this->islogin()){
			$this->load->view('template/dashboard');
		}
	}

	public function offer(){
		if($this->islogin()){
			$this->db->where('user_id',$this->session->userdata('user_id'));
			$this->db->where('status',1);
			$check['user'] = $this->db->get('offer_letter')->result_array();

			$this->load->view('template/pages/forms/basic_elements', $check);
		}
	}

	public function create_offer(){
		if($this->islogin()){
			$title = $this->security->xss_clean(htmlspecialchars($this->input->post('title')));
			$email = $this->security->xss_clean(htmlspecialchars($this->input->post('email')));
			$name = $this->security->xss_clean(htmlspecialchars($this->input->post('name')));
			$cell = $this->security->xss_clean(htmlspecialchars($this->input->post('cell')));
			$add1 = $this->security->xss_clean(htmlspecialchars($this->input->post('add1')));
			$add2 = $this->security->xss_clean(htmlspecialchars($this->input->post('add2')));
			$city = $this->security->xss_clean(htmlspecialchars($this->input->post('city')));
			$state = $this->security->xss_clean(htmlspecialchars($this->input->post('state')));
			$zipcode = $this->security->xss_clean(htmlspecialchars($this->input->post('zipcode')));
			$country = $this->security->xss_clean(htmlspecialchars($this->input->post('country')));
			$position = $this->security->xss_clean(htmlspecialchars($this->input->post('position')));
			$location = $this->security->xss_clean(htmlspecialchars($this->input->post('location')));
			$salary = $this->security->xss_clean(htmlspecialchars($this->input->post('salary')));
			$from_date = $this->security->xss_clean(htmlspecialchars($this->input->post('from_date')));
			$to_date = $this->security->xss_clean(htmlspecialchars($this->input->post('to_date')));
			$reference = $this->security->xss_clean(htmlspecialchars($this->input->post('ref')));
			$offer_letter_id = $this->security->xss_clean(htmlspecialchars($this->input->post('offer_letter_id')));
	
			if(empty($name)){
				$json = file_get_contents('php://input');
				$data = json_decode($json);
				$title = $this->security->xss_clean(htmlspecialchars($data->title, ENT_QUOTES));
				$email = $this->security->xss_clean(htmlspecialchars($data->email, ENT_QUOTES));
				$name = $this->security->xss_clean(htmlspecialchars($data->name, ENT_QUOTES));
				$cell = $this->security->xss_clean(htmlspecialchars($data->cell, ENT_QUOTES));
				$add1 = $this->security->xss_clean(htmlspecialchars($data->add1, ENT_QUOTES));
				$add2 = $this->security->xss_clean(htmlspecialchars($data->add2, ENT_QUOTES));
				$city = $this->security->xss_clean(htmlspecialchars($data->city, ENT_QUOTES));
				$state = $this->security->xss_clean(htmlspecialchars($data->state, ENT_QUOTES));
				$zipcode = $this->security->xss_clean(htmlspecialchars($data->zipcode, ENT_QUOTES));
				$country = $this->security->xss_clean(htmlspecialchars($data->country, ENT_QUOTES));
				$position = $this->security->xss_clean(htmlspecialchars($data->position, ENT_QUOTES));
				$location = $this->security->xss_clean(htmlspecialchars($data->location, ENT_QUOTES));
				$salary = $this->security->xss_clean(htmlspecialchars($data->salary, ENT_QUOTES));
				$from_date = $this->security->xss_clean(htmlspecialchars($data->from_date, ENT_QUOTES));
				$to_date = $this->security->xss_clean(htmlspecialchars($data->to_date, ENT_QUOTES));
				$reference = $this->security->xss_clean(htmlspecialchars($data->ref, ENT_QUOTES));
				$offer_letter_id = $this->security->xss_clean(htmlspecialchars($data->offer_letter_id, ENT_QUOTES));
			}
	
			$this->form_validation->set_rules('name', 'Full Name','required|min_length[6]',
				array(
						'required'      => 'You have not provided %s.',
						'min_length' => '%s must be at least 6 characters long',
				)
			);
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('position', 'Position', 'required');
			$this->form_validation->set_rules('from_date', 'From Date', 'required');
			// $this->form_validation->set_rules('branch', 'Branch', 'required');
			$this->form_validation->set_rules('cell', 'Cell', 'required|min_length[10]|max_length[10]',
				array(
					'required'      => 'You have not provided %s.',
					'min_length' => '%s must be at least 10 characters long',
					'max_length' => '%s must be at least 10 characters long',
				)
			);
			$this->form_validation->set_rules('add1', 'Address Line - 1', 'required|min_length[16]|max_length[26]',
				array(
					'required'      => 'You have not provided %s.',
					'min_length' => '%s must be at least 16 characters long',
					'max_length' => '%s must be at least 26 characters long',
				)
			);
			$this->form_validation->set_rules('add2', 'Address Line - 2', 'min_length[16]|max_length[26]',
				array(
					'min_length' => '%s must be at least 16 characters long',
					'max_length' => '%s must be at least 26 characters long',
				)
			);
			$this->form_validation->set_rules('city', 'City', 'required|max_length[16]',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 16 characters long',
				)
			);
			$this->form_validation->set_rules('state', 'State', 'required|max_length[16]',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 16 characters long',
				)
			);
			$this->form_validation->set_rules('zipcode', 'ZipCode', 'required|max_length[6]|numeric',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 6 characters long',
					'numeric' => 'Only Numbers accepted'
				)
			);
			$this->form_validation->set_rules('salary', 'Salary', 'required|max_length[6]|numeric',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 6 characters long',
					'numeric' => 'Only Numbers accepted'
				)
			);
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[offer_letter.email]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.',
					'valid_email' => 'This %s is not valid',
				)
			);
	
			if(!$this->form_validation->run()){
				$response = array(
					'msg'=> 'Error!! In your Application Form',
					'errors' => validation_errors(),
					'status' => 0,
				);
			}else{
				$data = array(
					'user_id'=> $this->session->userdata('user_id'),
					'emp_id'=> $this->session->userdata('user_id').rand(0,date('Y')),
					'emp_name'=> $name,
					'email' => $email,
					'country' => $country,
					'title' => $title,
					'phone' => $cell,
					'add_1' => $add1,
					'add_2' => $add2,
					'city' => $city,
					'state' => $state,
					'pincode' => $zipcode,
					'position' => $position,
					'location' => $location,
					'salary' => $salary,
					'title' => $title,
					'status' => 1,
					'from_date' => $from_date,
					'to_date' => $to_date,
					'reference' => $reference,
				);
				
				$this->db->where('offer_letter_id',$offer_letter_id);
				$signup_check = $this->db->update('offer_letter', $data);
	
				if($signup_check){
					$response = array(
						'msg'=> 'Application registered successfully with us!!',
						'url' => base_url('welcome/create_pdf/'.$this->my_simple_crypt($offer_letter_id, 'e')),
						'status' => 1,
					);
				}else{
					$response = array(
						'msg'=> 'Network Error!! Please try after some time',
						'status' => 0,
					);
				}
			}
			echo json_encode($response);   exit();
		}
	}

	public function create_pdf(){
		if($this->islogin()){
			$encrypt_value = $this->my_simple_crypt($this->uri->segment(3), 'd');

			$this->db->where('offer_letter_id',$encrypt_value);
			$this->db->where('status',1);
			$this->db->limit(1);
			$check = $this->db->get('offer_letter');

			if($check->num_rows() > 0){
				$user = $check->row_array();

				$pdf = $this->mypdf->getInstance();
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Offer: Sunglade Digital Solutions',0,1);
				$pdf->Cell(0,6,'Ref: SDSL/DT'.substr($user['from_date'], 0, 4).'/'.$user['emp_id'].'/'.$user['location'],0,1);
				$pdf->Cell(0,6,'Date: '.$user['from_date'],0,1);
				$pdf->SetFont('Times','',12);
				
				$pdf->Ln(6);
				$pdf->Cell(0,6, $user['title'].'. '.$user['emp_name'],0,1);
				$pdf->Cell(0,6,$user['add_1'],0,1);
				$pdf->Cell(0,6,$user['add_2'],0,1);
				$pdf->Cell(0,6,$user['city'].'-'.$user['pincode'],0,1);
				$pdf->Cell(0,6,$user['state'].'.',0,1);
				$pdf->Cell(0,6,'Tel# - '.$user['phone'],0,1);
				
				$pdf->Ln(6);
				$pdf->Cell(0,6,'Dear '.$user['emp_name'].',',0,1);

				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Sub: Letter of Offer',0,1);

				$pdf->Ln(6);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Thank you for exploring career opportunities with Sunglade Digital Solutions (SDS). You have successfully completed our initial selection process and we are pleased to make you an offer.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'This offer is based on your profile and performance in the selection process. You have been selected for the position of Software Trainee in Grade L5. Your gross salary including all benefits will be 1,47,600/- per annum, as per the terms and conditions set out herein. The gross salary mentioned above is inclusive of the Variable Allowance becoming effective upon successful completion of the Initial Training Programme.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'Kindly confirm your acceptance of this offer online through the option "Accept Offer letter". If not accepted within 7 days, it will be construed that you are not interested in this employment and this offer will be automatically withdrawn',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'After you accept this offer, you will be given a joining letter indicating the details of your joining 
				date and initial place of posting. You will also be issued a letter of appointment at the time of your joining after completing joining formalities as per company policy.',0,1);
				$pdf->Ln(4);
				
				$pdf->SetFont('Times','BU',12);
				$pdf->Cell(0,6,'COMPENSATION AND BENEFITS',0,1);
				$pdf->Ln(4);
				$pdf->SetFont('Times','BU',12);
				$pdf->Cell(0,6,'BASIC SALARY',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'You will be eligible for a basic salary of `7,100/- per month',0,1);

				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'BOUQUET OF BENEFITS (BoB)',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Bouquet of Benefits offers you the flexibility to design this part of your compensation within the 	defined framework, twice in a financial year. All the components will be disbursed on a monthly basis.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'The components under Bouquet of Benefits are listed below. The amounts given here for each of the components below are as per pre-defined structure. However you may want to redistribute the BoB amount between the components as per your tax plan, once you join SDS. Taxation will be governed by the Income Tax rules. SDS will be deducting tax at source as per income tax guidelines.',0,1);
				$pdf->Ln(6); // New Page
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'1. House Rent Allowance (HRA)',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->SetMargins(10,0,0);
				$pdf->MultiCell(0,6,'Your HRA will be Rs.1,500/- per month. While restructuring your BoB amount to various components, it is mandatory that at least 5% of monthly basic pay be allocated towards HRA.',0,1);

				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'2. Conveyance Allowance',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->SetMargins(10,0,0);
				$pdf->MultiCell(0,6,'You will be eligible for a conveyance allowance of 800/- per month after your 1 year of work.',0,1);

				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'2. Leave Travel Allowance',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->SetMargins(10,0,0);
				$pdf->MultiCell(0,6,'You will be eligible for annual Leave Travel Allowance which is equivalent to one month`s basic salary or a pro-rata amount in case you join during the financial year. This will be disbursed on a monthly basis along with the monthly salary. To avail income tax benefits, you need to apply for a minimum of three days of leave and submit supporting travel
				documents.',0,1);

				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'3. Personal Allowance',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->SetMargins(10,0,0);
				$pdf->MultiCell(0,6,'You will be eligible for a monthly personal allowance of `1,400/- per month. This
				component is subject to review and may change as per TCSL`s compensation policy',0,1);

				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'4. Sundry Medical Reimbursement',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->SetMargins(10,0,0);
				$pdf->MultiCell(0,6,'You will be eligible for reimbursement of sundry medical expenses incurred by you for you and your family. You are eligible for 7,200/- per annum or a pro-rata amount in case you join during the financial year. This will be disbursed on a monthly basis along with the monthly salary. To avail tax benefit you may submit medical bills for the same at the end of each calendar quarter. At the end of the financial year, the unveiled amount will be taxable',0,1);

				$pdf->Ln(6);
				$pdf->SetFont('Times','BU',12);
				$pdf->Cell(0,6,'PERFORMANCE PAY',0,1);
				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'1. Monthly Performance Pay',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'You will receive a monthly performance pay of `1,500/-. The same will be reviewed on completion of your first Anniversary with the company and will undergo a change basis your own ongoing individual performance.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'This Pay shall be treated as productivity bonus in lieu of statutory profit bonus.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'2. Quarterly Variable Allowance',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Your variable allowance will be 550/- per month, and will be paid at the closure of each quarter based on the performance of the company and your unit and to the extent of your allocation to the business unit.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'Quarterly Variable Allowance is subject to review on your first anniversary and may undergo a change based on the actual performance of the Company, your business unit and your own ongoing individual performance. The payment is subject to your being active on the company rolls on the date of announcement of Quarterly Variable Allowance.',0,1);

				$pdf->Ln(6);
				$pdf->SetFont('Times','BU',12);
				$pdf->Cell(0,6,'OTHER BENEFITS',0,1);
				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Maternity Leave',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Women employees are eligible to avail maternity leave of twenty six weeks. Adopting or commissioning mother,may avail maternity leave for twelve weeks. For more details on the benefits and eligibility, once you join, please refer TCS India Policy - Maternity Leave.',0,1);
				
				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Loans',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'You will be eligible for loans, as per SDSL`s loan policy.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Sunglade Digital Solutions Services Employees` Welfare Trust (SDSSEWT)',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'You will become a member of the TWT, on completion of continuous association of one year from the date of joining TCSL. A nominal annual membership fee of `250/- will be recovered from you for the same. The Trust provides financial assistance by way of grants/ loans in accordance with the rules framed by the Trust from time to time for medical and educational purposes and in case of death of members while in service.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Professional Memberships',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'You will be eligible for reimbursement of expense-s towards professional membership as per
				SDSL`s policy.',0,1);

				$pdf->Ln(6);
				$pdf->SetFont('Times','BU',12);
				$pdf->Cell(0,6,'TERMS AND CONDITIONS',0,1);
				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'1. Aggregate Percentage Requirements',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Your appointment will be subject to your scoring minimum aggregate (aggregate of all subjects in all semesters) marks of 60% or above in the first attempt in each of your Standard Xth, Standard XIIth, Diploma (if applicable), Graduation and Post-Graduation examination which includes successful completion of your final semester/year without any pending
				arrears/back logs during the entire course duration. As per the SDS eligibility criteria, marks/CGPA obtained during the normal duration of the course only will be considered to decide on the eligibility.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'As communicated to you through various forums during the recruitment process, your appointment is subject to completion of your course within the stipulated time as specified by your University/Institute and as per SDS selection guidelines.',0,1);
				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'It is mandatory to declare the gaps/arrears/backlogs, if any, during your academics and work experience. The management reserves the right to withdraw/revoke the offer/appointment at any time at its sole discretion in case any discrepancy or false information is found in the details submitted by you',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'2. Disclaimer',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Candidates who have applied to SDS and who have not been successful in clearing the SDS Selection process are not eligible to re-apply to SDS within six months from the date on which	the candidate had attended such selection Test and/or Interview. In case you are found to have re-applied to SDS within six months of previous unsuccessful attempt, the management
				reserves the right to revoke/withdraw the offer/appointment, without prejudice to its other rights.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'3. Working Hours',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'You may be required to work in shifts and/or in extended working hours as permitted by law. You may be required to work beyond your existing working hours depending upon the business requirements/exigencies from time to time.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'4. Mobility',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'SDS reserves the right to transfer you at any of its offices, work sites, or associated or	affiliated companies in India or outside India, on the terms and conditions as applicable to you at the time of transfer.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'5. Compensation Structure/Salary components',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'The compensation structure/salary components are subject to change as per SDS`s compensation policy from time to time at its sole discretion.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'6. Increments and Promotions',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Your performance and contribution to SDS will be an important consideration for salary increments and promotions. Salary increments and promotions will be based on SDS`s Compensation and Promotion policy.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'7. Alternative Occupation/Employment',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'Either during the period of your traineeship or during the period of your employment as a	confirmed employee of SDS, you are not permitted to undertake any other employment,	business, assume any public or private office, honorary or remunerative, without the prior written permission of SDS.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'8. Confidentiality Agreement',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'As part of the joining formalities, you are required to sign a confidentiality agreement, which
				aims to protect the intellectual property rights and business information of SDS and its clients.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'9. Service Agreement',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'As SDS will be incurring considerable expenditure on your training, you will be required to execute an agreement, to serve SDS for a minimum period of 2 years after joining, failing which, you (and your surety) will be liable to pay SDS 50,000/- towards the training expenditure.',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'10. TERMS and CONDITIONS',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'The above terms and conditions are specific to India and there can be changes to the said terms and conditions in case of deputation on international assignments.',0,1);


				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->Cell(0,6,'Withdrawal of Offer',0,1);
				$pdf->SetFont('Times','',12);
				$pdf->MultiCell(0,6,'If you fail to accept the offer from SDS within 7 days, it will be construed that you are not interested in this employment and this offer will be automatically withdrawn.',0,1);

				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'Post acceptance of SDS Offer letter if you fail to join on the date provided in the SDS Joining letter, the offer will stand automatically terminated at the discretion of SDS.',0,1);

				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'We look forward to having you in our global team.',0,1);

				$pdf->Ln(4);
				$pdf->MultiCell(0,6,'Yours Sincerely,',0,1);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->MultiCell(0,6,'For Sunglade Digital Solutions',0,1);

				$image1 = 'asset/sunglade.png';
				$pdf->SetFont('Arial','B',15);
				$pdf->Cell(80);
				$pdf->Cell( 40, 40, $pdf->Image($image1, 10, $pdf->Gety(), 56), 0, 0, 'L', false );
				$pdf->Cell( 40, 40, $pdf->Image($image1, 12, $pdf->Gety(), 56), 0, 0, 'L', false );
				$pdf->Ln(16);

				$pdf->Ln(4);
				$pdf->SetFont('Times','B',12);
				$pdf->MultiCell(0,6,'Priya',0,1);
				$pdf->MultiCell(0,6,'Global Head Talent Acquisition & AIP',0,1);

				$pdf->Output(); 
			}
		}
	}

	//Payment
	public function get_curl_handle()  {
		if($this->islogin()){
			$payment_id = $this->security->xss_clean(htmlspecialchars($this->input->post('payment_id'), ENT_QUOTES));
			$amount = $this->security->xss_clean(htmlspecialchars($this->input->post('amount'), ENT_QUOTES));

			//Check the email already present or not --- Not needed in other projects
			$email = $this->security->xss_clean(htmlspecialchars($this->input->post('email'), ENT_QUOTES));

			$this->db->where('email',$email);
			$check = $this->db->get('offer_letter');

			if($check->num_rows() > 0){
				$result[] = array(
					'msg'=> 'Email id already registered with us.',
					'status'=> 0,
				);
			}else{

				//Important Code
				if(!empty($payment_id) && !empty($amount)){
					$url = 'https://api.razorpay.com/v1/orders';
					$key_id = key_id_test;
					$key_secret = key_secret_test;
					$fields_string = array(
								"amount"=>$amount,
								"currency"=> "INR",
								"receipt"=> $payment_id,
								'payment_capture'=> 1,
					);
	
					$ch = curl_init();
					//set the url, number of POST vars, POST data
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
					curl_setopt($ch, CURLOPT_TIMEOUT, 60);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields_string));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//Get response
					$server_output = curl_exec($ch);
					curl_close ($ch);
	
					$result[] = array(
						'msg'=> json_decode($server_output),
						'status'=> 1,
					);
				}else{
					$result[] = array(
						'msg'=> 'Invalid request',
						'status'=> 0,
					);
				}
				//Important Code
			}
			
			
			echo json_encode($result);exit();
		}
	}

	public function payment(){
		if($this->islogin()){
			// $org_id = $this->security->xss_clean(htmlspecialchars($this->input->post('org_id'), ENT_QUOTES));
			$payment_amount = $this->security->xss_clean(htmlspecialchars($this->input->post('payment_amount'), ENT_QUOTES));
			$payment_date = $this->security->xss_clean(htmlspecialchars($this->input->post('payment_date'), ENT_QUOTES));
			$razorpay_payment_id = $this->security->xss_clean(htmlspecialchars($this->input->post('razorpay_payment_id'), ENT_QUOTES));
			$payment_status = $this->security->xss_clean(htmlspecialchars($this->input->post('payment_status'), ENT_QUOTES));

			if(!empty($payment_amount) && !empty($razorpay_payment_id) && !empty($payment_status)){
				//!empty($org_id)
				// $this->db->where('user_id',$this->session->userdata('user_id'));
				// $pay = $this->db->get('offer_letter')->result_array();

				// if(sizeof($pay) > 0){
				// 	$index = sizeof($pay);
				// 	$due_date = $pay[$index-1]['payment_due_date'];
				// 	if($due_date > date('Y-m-d')){
				// 		$payment_due_date = date('Y-m-d H:i:s', strtotime($due_date . ' +30 day'));
				// 	}else{
				// 		$payment_due_date = date('Y-m-d H:i:s', strtotime($payment_date . ' +30 day'));
				// 	}
				// }else{
				// 	$payment_due_date = date('Y-m-d H:i:s', strtotime($payment_date . ' +30 day'));
				// }

				$data = array(
					'user_id'=> $this->session->userdata('user_id'),
					'payment_amount'=> $payment_amount,
					'payment_date'=> date('Y-m-d'),
					'razorpay_payment_id'=> $razorpay_payment_id,
					'payment_status'=> $payment_status,
					// 'payment_due_date'=> $payment_due_date,
					'status'=> 1,
				);

				$payment_success = $this->db->insert('offer_letter', $data);

				if($payment_success){
					$result[] = array(
						// 'csrfName' => $this->security->get_csrf_token_name(),
						// 'csrfHash' => $this->security->get_csrf_hash(),
						'msg'=>'Thank You for Making Payment.',
						'id'=> $this->db->insert_id(),
						'status'=>1,
					);
				}else{
					$result[] = array(
						// 'csrfName' => $this->security->get_csrf_token_name(),
						// 'csrfHash' => $this->security->get_csrf_hash(),
						'msg'=>'Network Error!! Please contact Admin with Payment Proof',
						'status'=>0,
					);
				}
			}else{
				$result[] = array(
					// 'csrfName' => $this->security->get_csrf_token_name(),
					// 'csrfHash' => $this->security->get_csrf_hash(),
					'msg'=>'Please contact Admin with Payment Proof',
					'status'=> 0,
				);
			}
			echo json_encode($result);
		}
	}

	public function update_add(){
		if($this->islogin()){
			$id = $this->security->xss_clean(htmlspecialchars($this->input->post('id')));
			$add1 = $this->security->xss_clean(htmlspecialchars($this->input->post('add1')));
			$add2 = $this->security->xss_clean(htmlspecialchars($this->input->post('add2')));
			$city = $this->security->xss_clean(htmlspecialchars($this->input->post('city')));
			$state = $this->security->xss_clean(htmlspecialchars($this->input->post('state')));
			$zipcode = $this->security->xss_clean(htmlspecialchars($this->input->post('zipcode')));

			if(empty($id)){
				$json = file_get_contents('php://input');
				$data = json_decode($json);
				$id = $this->security->xss_clean(htmlspecialchars($data->id, ENT_QUOTES));
				$add1 = $this->security->xss_clean(htmlspecialchars($data->add1, ENT_QUOTES));
				$add2 = $this->security->xss_clean(htmlspecialchars($data->add2, ENT_QUOTES));
				$city = $this->security->xss_clean(htmlspecialchars($data->city, ENT_QUOTES));
				$state = $this->security->xss_clean(htmlspecialchars($data->state, ENT_QUOTES));
				$zipcode = $this->security->xss_clean(htmlspecialchars($data->zipcode, ENT_QUOTES));
			}

			$this->form_validation->set_rules('add1', 'Address Line - 1', 'required|min_length[16]|max_length[26]',
				array(
					'required'      => 'You have not provided %s.',
					'min_length' => '%s must be at least 16 characters long',
					'max_length' => '%s must be at least 26 characters long',
				)
			);
			$this->form_validation->set_rules('add2', 'Address Line - 2', 'min_length[16]|max_length[26]',
				array(
					'min_length' => '%s must be at least 16 characters long',
					'max_length' => '%s must be at least 26 characters long',
				)
			);
			$this->form_validation->set_rules('city', 'City', 'required|max_length[16]',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 16 characters long',
				)
			);
			$this->form_validation->set_rules('state', 'State', 'required|max_length[16]',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 16 characters long',
				)
			);
			$this->form_validation->set_rules('zipcode', 'ZipCode', 'required|max_length[6]|numeric',
				array(
					'required'      => 'You have not provided %s.',
					'max_length' => '%s must be at least 6 characters long',
					'numeric' => 'Only Numbers accepted'
				)
			);

			$this->db->where('offer_letter_id', $id);
			$details = $this->db->get('offer_letter');

			if($details->num_rows() >0){
				$data = array(
					'add_1' => $add1,
					'add_2' => $add2,
					'city' => $city,
					'state' => $state,
				);
				
				$this->db->where('offer_letter_id',$id);
				$signup_check = $this->db->update('offer_letter', $data);
	
				if($signup_check){
					$response = array(
						'msg'=> 'Application updated successfully with us!!',
						'url' => base_url('welcome/create_pdf/'.$this->my_simple_crypt($id, 'e')),
						'status' => 1,
					);
				}else{
					$response = array(
						'msg'=> 'Network Error!! Please try after some time',
						'status' => 0,
					);
				}
			}else{
				$response = array(
					'msg'=> 'Invalid Input',
					'status'=> 0,
				);
			}
			echo json_encode($response); exit();
		}
	}

	public function get_add(){
		if($this->islogin()){
			$id = $this->security->xss_clean(htmlspecialchars($this->input->post('id')));
			

			if(empty($id)){
				$json = file_get_contents('php://input');
				$data = json_decode($json);
				$id = $this->security->xss_clean(htmlspecialchars($data->id, ENT_QUOTES));
			}

			$this->db->select('add_1,add_2,city,pincode,state');
			$this->db->where('offer_letter_id', $id);
			$details = $this->db->get('offer_letter');

			if($details->num_rows() >0){
				$response = array(
					'msg' => $details->row_array(),
					'status' => 1,
				);
			}else{
				$response = array(
					'msg'=> 'Invalid Input',
					'status'=> 0,
				);
			}
			echo json_encode($response); exit();
		}
	}

	private function islogin(){
        if(!empty($this->session->userdata('user_id'))){
            return true;
        }else{
            header('Location: '.base_url().'api/logout');
        }
    }

	function my_simple_crypt( $string, $action = 'e' ) {
		// you may change these values to your own
		$secret_key = 'my_simple_secret_key';
		$secret_iv = 'my_simple_secret_iv';
	 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
		if( $action == 'e' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'd' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	 
		return $output;
	}
}
