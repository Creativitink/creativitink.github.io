<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $email = $_POST['email'];

    $your_job_arr = $_POST['your_job'];
    $your_job =' ';
    if(!empty($your_job_arr)) {
        foreach($your_job_arr as $job){
            $your_job.= $job . " | ";
        }
    }

    if(isset($_POST['other_job'])){
        $other_job = $_POST['other_job'];
    }
    else{
        $other_job = 'N/A';
    }

    $better_f = $_POST['better_f'];
    $WTS = $_POST['WTS'];
    $commission = $_POST['commission'];
    $monetize = $_POST['monetize'];

    $list_id = 'd5f321cdae';
    $api_key = '4d3ab2514cfb3ff082cb0457b663c70c-us10';
    
    $data_center = substr($api_key,strpos($api_key,'-')+1);
    
    $url = 'https://'. $data_center .'.api.mailchimp.com/3.0/lists/'. $list_id .'/members';
    
    $json = json_encode([
        'email_address' => $email,
        'status'        => 'subscribed', //pass 'subscribed' or 'pending'
        'merge_fields'  => [
            'FNAME' => $name,
            'JOB' => $your_job,
            'OTHERJOB' => $other_job,
            'SURVEY_PAR' => $better_f,
            'WHATTOSELL' => $WTS,
            'PAYCOMM' => $commission,
            'MONETIZEP' => $monetize,
        ]
    ]);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);


    if($status_code = '200'){
        header("Location: ./index.php?code=success");
    }
    else{
        header("Location: ./index.php?code=error");
    }
    
    
}
?>


