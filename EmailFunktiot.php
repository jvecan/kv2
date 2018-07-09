<?php
class EmailFunktiot {

    private $db = 'localhost';
    private $dbName = '';
    private $dbUser = '';
    private $dbPassword = '';

    public function saveEmail($email) {
        if (!$this->validateEmail($email)) {
            $returnMessage = "Tarkista sähköpostiosoite. ";
        } else {
            $pdo = new PDO('mysql:host=' . $this->db . ';dbname=' . $this->dbName . ';charset=utf8mb4', $this->dbUser, $this->dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = $pdo->prepare("INSERT INTO email(email, verification_code) VALUES (:email, :verification_code)");
            $verificationCode = $this->generateVerificationCode();
            if ($query->execute(array("email" => $email, "verification_code" => $verificationCode))) {
                $returnMessage = "Sähköpostiosoite tallennettu. Tarkista sähköpostisi varmistaaksesi osoitteesi.";
                $this->sendVerificationEmail($email, $verificationCode);
            } else {
                $returnMessage = "Virhe tietokantaan tallennettaessa. ";
            }
        }
        return $returnMessage;
    }

    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
        // muut validoinnit
    }

    private function sendVerificationEmail($email, $verificationCode) {
        $to = $email;
        $subject = 'Sähköpostiosoitteen varmistus';
        $message = 'Klikkaa linkkiä varmistaaksesi osoitteesi: <a href="https://iikkamanninen.com/emailit/verifyEmail.php?email=' . $email . '&amp;verify=' . $verificationCode . '">Varmista osoite</a>';
        $headers = 'From: iikka.manninen@iikkamanninen.com' . "\r\n" .
                'Reply-To: iikka.manninen@iikkamanninen.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion() .
                "MIME-Version: 1.0" . "\r\n" .
        "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function validateVerificationEmail($email, $verificationCode) {
        $pdo = new PDO('mysql:host=' . $this->db . ';dbname=' . $this->dbName . ';charset=utf8mb4', $this->dbUser, $this->dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $pdo->prepare("SELECT verified FROM email WHERE verification_code = :verification_code AND email = :email");

        if ($this->validateEmail($email)) {
            $query->execute(array("verification_code" => $verificationCode, "email" => $email));
            $results = $query->fetchColumn();
            if ($results != 1) {
                $query = $pdo->prepare("UPDATE email SET verified = 1 WHERE verification_code = :verification_code AND email = :email");
                $query->execute(array("verification_code" => $verificationCode, "email" => $email));
                $returnMessage = "Validointi onnistui. ";
            } else {
                $returnMessage = "Validointi suoritettu aiemmin. ";
            }
        } else {
            $returnMessage = "Validointi epäonnistui. ";
        }
        return $returnMessage;
    }

    private function generateVerificationCode() {
        return md5(openssl_random_pseudo_bytes(32));
    }

}
