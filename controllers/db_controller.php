<?php

class DBControl
{

    private $_host;
    private $_user;
    private $_name;
    private $_pass;

    private $_connection;

    private function connectDB()
    {
        $this->_connection = mysqli_connect($this->_host, $this->_user, $this->_pass, $this->_name);
    }

    function DBControl($host, $user, $pass, $name)
    {
        $this->_host = $host;
        $this->_user = $user;
        $this->_name = $name;
        $this->_pass = $pass;

        $this->connectDB();
    }


    private $specialities = [
        "1" => "Информационные системы и программирование",
        "2" => "Сетевое и системное администрирование",
        "3" => "Компьютерные системы и комплексы"
    ];


    function createAchievement($gold_gto, $olympic_medalist)
    {
        $query = "INSERT INTO achievements SET Gold_GTO='$gold_gto', Olympic_Medalist = '$olympic_medalist'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        return mysqli_insert_id($this->_connection);
    }

    function createCertificate($Number, $Issue_Date, $Educational_Institution, $Scan_Certificate, $Scan_Аpplication_Certificate, $GPA)
    {
        $query = "INSERT INTO certificates SET Number='$Number', Issue_Date='$Issue_Date', Educational_Institution='$Educational_Institution', Scan_Certificate='$Scan_Certificate', Scan_Аpplication_Certificate ='$Scan_Аpplication_Certificate', Certificate_Original='0', GPA='$GPA'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        return mysqli_insert_id($this->_connection);
    }

    function createPassport($Series, $Number, $Issue_Date, $Division_Code, $Issued, $Scan_First_Passport, $Scan_Second_Passport)
    {
        $query = "INSERT INTO passports SET Series='$Series', Number='$Number', Issue_Date='$Issue_Date', Division_Code='$Division_Code', Issued='$Issued', Scan_First_Passport='$Scan_First_Passport', Scan_Second_Passport='$Scan_Second_Passport'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        return mysqli_insert_id($this->_connection);
    }

    function getStatusByName($statusName) {
        $query = "SELECT * FROM statuses WHERE name='$statusName' LIMIT 1";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        $status = mysqli_fetch_assoc($result);
        return $status;
    }

    function createApplicantsSpecialtie($Applicant_ID, $Speciality_ID) {
        $query = "INSERT INTO applicants_specialties SET Applicant_ID='$Applicant_ID', Speciality_ID='$Speciality_ID'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        return mysqli_insert_id($this->_connection);
    }

    function getSpecialityByName($specName) {
        $query = "SELECT * FROM specialties WHERE Name='$specName' LIMIT 1";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        $speciality = mysqli_fetch_assoc($result);
        return $speciality;
    }


    function createApplicant($firstFrame, $secondFrame, $thirdFrame)
    {
        $ahievement_id = $this->createAchievement($firstFrame['goldGTO'], $firstFrame['winner']);

        $passport_id = $this->createPassport($secondFrame['pass_seria'], $secondFrame['pass_number'], $secondFrame['date_out'], $secondFrame['podrazdel_number'], $secondFrame['who_otdal'], $secondFrame['first_scan'], $secondFrame['second_scan']);

        $certificate_id = $this->createCertificate($thirdFrame['at_number'], $thirdFrame['at_date'], $thirdFrame['at_name'], $thirdFrame['at_scan'], $thirdFrame['at_priloj_scan'], $thirdFrame['middle_number']);

        $a_Surname = $firstFrame['surname'];
        $a_Name = $firstFrame['name'];
        $a_Patronymic = $firstFrame['patronymic'];
        $a_Sex = $firstFrame['sex'] == "1" ? "М" : "Ж";
        $a_Birth_Date = $firstFrame['birthDay'];
        $a_Email = $firstFrame['email'];
        $a_Phone_Number = $firstFrame['phone'];
        $a_Photo = $firstFrame['photoFace'];
        
        $id_status = $this->getStatusByName("В обработке")['ID_Status'];

        $query = "INSERT INTO applicants SET Surname='$a_Surname', Name='$a_Name', Patronymic='$a_Patronymic', Sex='$a_Sex', Birth_Date='$a_Birth_Date', Email='$a_Email', Phone_Number='$a_Phone_Number', Photo='$a_Photo', Passport_ID='$passport_id', Achievement_ID='$ahievement_id', Certificate_ID='$certificate_id', id_status='$id_status'";

        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));

        $applicant_id = mysqli_insert_id($this->_connection);

        if(isset($thirdFrame['spec'])) {
            if(is_array($thirdFrame['spec'])) {
                foreach($thirdFrame['spec'] as $checkNum) {
                    $spec_id = $this->getSpecialityByName($this->specialities[$checkNum])['ID_Speciality'];

                    $this->createApplicantsSpecialtie($applicant_id, $spec_id);
                }
            }
            else {
                $spec_id = $this->getSpecialityByName($this->specialities[$thirdFrame['spec']])['ID_Speciality'];

                $this->createApplicantsSpecialtie($applicant_id, $spec_id);
            }
        }

    }

    function updateApplicantStatus($id_applicant, $status_name) {
        $id_status = $this->getStatusByName($status_name)['ID_Status'];
        $query = "UPDATE applicants SET id_status='$id_status' WHERE ID_Applicant='$id_applicant'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
    }


    function getApplicantsForTable() {
        $statusCompleteId = $this->getStatusByName("Конкурс")['ID_Status'];
        $query = "SELECT applicants.*, CONCAT(applicants.Surname, ' ', applicants.Name, ' ', applicants.Patronymic) as FIO, certificates.GPA FROM applicants LEFT JOIN certificates ON applicants.Certificate_ID = certificates.ID_Certificate WHERE applicants.id_status='$statusCompleteId'";

        if(isset($_GET['FIO'])) {
            $query .= " AND CONCAT(applicants.Surname, ' ', applicants.Name, ' ', applicants.Patronymic) LIKE '%{$_GET['FIO']}%'";
        }

        if(isset($_GET["sortBy"])) {
            $query .= " ORDER BY {$_GET["sortBy"]}";
            if(isset($_GET["direction"])) {
                $query .= " {$_GET["direction"]}";
            }
        }
        else {
            $query .= " ORDER BY GPA DESC";
        }


        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

        //Номер в конкурсе

        $query2 =  "SELECT applicants.*, CONCAT(applicants.Surname, ' ', applicants.Name, ' ', applicants.Patronymic) as FIO, certificates.GPA FROM applicants LEFT JOIN certificates ON applicants.Certificate_ID = certificates.ID_Certificate WHERE applicants.id_status='$statusCompleteId' ORDER BY GPA DESC";

        $result2 = mysqli_query($this->_connection, $query2) or die(mysqli_error($this->_connection));
        for($data2 = []; $row2 = mysqli_fetch_assoc($result2); $data2[] = $row2);

        for($i = 0; $i < count($data); $i++) {
            for($j = 0; $j < count($data2); $j++) {
                if($data[$i]['ID_Applicant'] == $data2[$j]['ID_Applicant']) {
                    $data[$i]['row_number'] = $j + 1;
                }
            }
        }

        //Номер в конкурсе;

        return $data;
    }


    
    function getApplicantsForTableAdmin() {
        $query = "SELECT applicants.*, certificates.GPA, statuses.name as status FROM applicants LEFT JOIN certificates ON applicants.Certificate_ID = certificates.ID_Certificate LEFT JOIN statuses ON statuses.ID_Status = applicants.id_status";

        if(isset($_GET["sortBy"])) {
            $query .= " ORDER BY {$_GET["sortBy"]}";
            if(isset($_GET["direction"])) {
                $query .= " {$_GET["direction"]}";
            }
        }
        else {
            $query .= " ORDER BY GPA DESC";
        }


        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        return $data;
    }


    function checkAuth($login, $password) {
        $query = "SELECT * FROM employees WHERE Login='$login' AND Password='$password'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        if(count($data) == 0) {
            return false;
        }
        return true;
    }


    function checkHasEmail($email) {
        $query = "SELECT * FROM applicants WHERE email='$email'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        if(count($data) == 0) {
            return false;
        }
        return true;
    }

    function checkHasPhone($phone) {
        $query = "SELECT * FROM applicants WHERE Phone_Number='$phone'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        if(count($data) == 0) {
            return false;
        }
        return true;
    }

    function checkHasCertificateNumber($number) {
        $query = "SELECT * FROM certificates WHERE Number='$number'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        if(count($data) == 0) {
            return false;
        }
        return true;
    }

    function checkHasPassport($pass_seria, $pass_number) {
        $query = "SELECT * FROM passports WHERE Series='$pass_seria' AND Number='$pass_number'";
        $result = mysqli_query($this->_connection, $query) or die(mysqli_error($this->_connection));
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        if(count($data) == 0) {
            return false;
        }
        return true;
    }
}

$DB = new DBControl(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_NAME"));

?>