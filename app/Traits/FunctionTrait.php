<?php
namespace App\Traits;

use App\Models\ImageItem;
use App\Models\User\VerificationCode;

trait FunctionTrait {

    public function getCode() {
        $existingToken = null;
        $code = null; // تعريف المتغير الذي سيحتوي على الرمز الفريد
        do {
            $code = $this->newCode();
            $existingToken = VerificationCode::where('code', $code)->first();
        } while ($existingToken);

        return $code; // قم بإعادة الرمز الفريد هنا
    }


    function send_email ($to , $username , $verification_code = ''  ,$subject = '! Please use the following verification' , $msg = 'code to activate your account:') {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <info@almashreqebookstore.com>' . "\r\n";
        $htmlContent = '<!DOCTYPE html>';
        $htmlContent .= '<html lang="en">';
        $htmlContent .= '<head>';
        $htmlContent .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">';
        $htmlContent .= '<link href="https://fonts.googleapis.com/css2?family=Imprima&display=swap" rel="stylesheet">';
        $htmlContent .= '</head>';
        $htmlContent .= '<body>';

        $htmlContent .= '<div class="row mt-4">';
        $htmlContent .= '<div class="col-12">';
        $htmlContent .= '<h3 class="mb-3">Hi ' . $username . ',</h3>';
        $htmlContent .= '<p>Welcome to our website';
        $htmlContent .= '<br><br>';
        $htmlContent .= '' . $subject . '';
        $htmlContent .= '<br><br>';
        $htmlContent .= '' . $msg . '';
        $htmlContent .= '</p>';
        $htmlContent .= '<div class="col-12">';
        $htmlContent .= '<p> ' . $verification_code .'</p>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';

        $htmlContent .= '<div class="row mt-4">';
        $htmlContent .= '<div class="col-12">';
        $htmlContent .= '<p>Thanks,<br><br> -</p>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';

        $htmlContent .= '<!-- دعوة لحجز عرض توضيحي -->';
        $htmlContent .= '<div class="row mt-4">';
        $htmlContent .= '<div class="col-12">';
        $htmlContent .= '<p>We wish you a happy day</p>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';

        $htmlContent .= '<!-- توقيع البريد الإلكتروني -->';
        $htmlContent .= '<div class="row mt-4">';
        $htmlContent .= '<div class="col-12">';
        $htmlContent .= '<p><a href="#">Privacy Policy</a> • <a href="#">Unsubscribe</a></p>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';

        $htmlContent .= '<div class="row mt-4">';
        $htmlContent .= '<div class="col-12">';
        $htmlContent .= '<p>&copy; 2023 Company</p>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';

        $htmlContent .= '</div>';
        $htmlContent .= '</body>';
        $htmlContent .= '</html>';

        @mail($to,'Almashreqe book store',$htmlContent,$headers);
    }

    public function newCode(){
        $alphabet = '0123456789';
        $token = '';
        for ($i = 0; $i <= 3; $i++) {
            $index = rand(0, strlen($alphabet) - 1);
            $token .= $alphabet[$index];
        }

        return $token;
    }



    function generateRandomToken() {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < 5; $i++) {
            $index = rand(0, strlen($alphabet) - 1);
            $token .= $alphabet[$index];
        }

        return $token;
    }

    function generateUniqueTokenImage() {
        do {
            $token = $this->generateRandomToken();
            $existingToken =ImageItem::where('token', $token)->first();
        } while ($existingToken);
        return $token;
    }

}
