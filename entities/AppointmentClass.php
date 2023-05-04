<?php

class Appointment {
    public $service   ;
    public $name      ;
    public $telNumber ;
    public $appDate   ;
    public $appTime   ; 
    public  $Age ;
    public  $Fname ;
    

  // Methods
  function __construct($service, $name, $telNumber, $appDate, $appTime ,$Age,$Fname) {
    $this->service   = $service;
    $this->name      = $name;
    $this->telNumber = $telNumber;
    $this->appDate   = $appDate;
    $this->appTime   = $appTime;
    $this->Fname   = $Fname;
    $this->Age   = $Age;
  }

  function changeFormateDate()
  {
    $month = substr($this->appDate,0,2);
    $day = substr($this->appDate,3,2);
    $year = substr($this->appDate,6,4);
    $this->appDate = $year . "-" . $month . "-" . $day;
  }

  function calendarVerification()
  {
    $conn = new mysqli("localhost", "root", "","tpts_db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT appDate, appTime FROM appointment WHERE appDate = '".$this->appDate."';";
    $result = $conn->query($sql);
    $busyTime="";
    if ($result==true && $result->num_rows > 0) {

      $OneHour= 60*60;
      
    while($row = $result->fetch_assoc()) {
      if(strtotime($row["appTime"]) >=  strtotime($this->appTime)-$OneHour && strtotime($row["appTime"]) <=  strtotime($this->appTime)+$OneHour)
      {
        $busyTime = $busyTime. "from " . $row["appTime"]. " to " . date('H:i',strtotime($row["appTime"])+$OneHour) . " <br>";
      }


    }
    }
    else
    {
      //echo "0 results";
    }
    return $busyTime;
  }

  function verification()
  {
    //notEmptyTesting
    if(! empty($this->name) && ! empty($this->service) && ! empty($this->telNumber) && ! empty($this->appDate) && ! empty($this->appTime) && ! empty($this->Age) &&  ! empty( $this->Fname))
    {
      $notEmptyTesting=true;
      $notEmptyErrorMessage="";
    }
    else
    {
      $notEmptyTesting=false;
      $notEmptyErrorMessage="ALL CASES SHOULD BE FILLED";
    }


    //telNumberIsNumiricTesting
    if(is_numeric($this->telNumber) == 1 && strlen($this->telNumber) == 8)
    {
      $telNumberIsNumiricTesting = true;
      $telNumberIsNumiricErrorMessage="";
    }
    else
    {
      $telNumberIsNumiricTesting = false;
      $telNumberIsNumiricErrorMessage="<br> incorrect phone number";
    }


    //dateTesting
    if( strtotime($this->appDate) >  strtotime(date('m/d/Y')))
    {
      $dateTesting = true;
      $dateErrorMessage ="";
    }
    else
    {
      $dateTesting = false;
      $dateErrorMessage ="<br> choose date after current date";
    }

    //timeTesting 
    if( strtotime($this->appTime) >=  strtotime("09:00 AM") && strtotime($this->appTime) <=  strtotime("04:00 PM"))
    {
      $timeTesting = true;
      $timeErrorMessage ="";
    }
    else
    {
      $timeTesting = false;
      $timeErrorMessage ="<br> choose  time between 09:00 AM and 04:00 PM";
    }

    //freeTime testing
    if($this->calendarVerification() == "")
    {
      $freeTimeTesting = true;
      $freeTimeErrorMessage = "";
    }
    else
    {
      $freeTimeTesting = false;
      $freeTimeErrorMessage = "<br> booked time:<br>".$this->calendarVerification();
    }

    if($notEmptyTesting && $telNumberIsNumiricTesting && $dateTesting && $timeTesting &&  $freeTimeTesting)
    {
      header("Location:thank-you.php");
      exit();
    }

    if(! $notEmptyTesting)
    {
      return $notEmptyErrorMessage;
    }
    return $telNumberIsNumiricErrorMessage . $dateErrorMessage . $timeErrorMessage.$freeTimeErrorMessage;

  }

  function create()
  {
    $conn = new mysqli("localhost", "root", "","tpts_db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "INSERT INTO appointment (service, name, appDate,appTime,telNumber ,Age,Fname) VALUES
      ( '" . $this->service . "', '" . $this->name . "', '" .  $this->appDate . " ','" . $this->appTime . "', '" . $this->telNumber . "' , '" . $this->Age . "' , '" . $this->Fname . "');";

if ($conn->query($sql) === false) {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
    
    
    $conn->close();


  }
}
?>