<?php

    $filename = "log.txt";
    $succes_message = " вы успешно зарегистрированлись";
    $log_text = "Пользователь имя:".$_POST['name']."\n".
        "фамилия: ".$_POST['forname']."\n".
        "mail: ".$_POST['email']."\n";
    
    class User{
        var $id;
        var $mail;
        var $name;

        function __construct($id, $mail, $name){
            $this->id = $id;
            $this->mail = $mail;
            $this->name = $name;
        }
    }

    $user_array = array( 
        new User(0, "mail0@mail.ru", "Антон"),
        new User(1, "mail1@mail.ru", "Ант"),
        new User(2, "mail2@mail.ru", "Он"),
    );

    function validation_mail($mail){
        global $user_array;
        foreach($user_array as $item){
            if($item->mail == $mail)
                return true;
        }
        return false;
    }

    function message($result, $errorCode){
        $message = array('message' => $result, 'code' => $errorCode);
        echo json_encode($message); 
        log_in_file($result, $errorCode);
        exit;
    }

    function log_in_file($result, $errorCode){
        global $filename;
        global $log_text;

        $file = fopen($filename, "a");
        if($errorCode)
            fwrite($file, $log_text."Не прошел регистрацию: ".$result."\n\n");
        else
            fwrite($file, $log_text."Успешно зарегистрирован"."\n\n");
        fclose($file);
    }

    if(strlen($_POST['name'] <= 1))
       message("Введите имя", 1); 
    else if(strlen($_POST['forname'] <= 1))
        message("Введите фамилию", 2);
    else if(!strpos($_POST['email'], "@"))
        message("Неправильный адрес почты", 3);
    else if($_POST['pass'] <= 3)
        message("Слабый пароль", 4);
    else if($_POST['pass'] != $_POST['repass'])
        message("Пароли не совпадают", 5);
    else if(validation_mail($_POST['email']))
        message("Эта почта уже используется", 6);
    else
        message($_POST['name'].$succes_message, 0);
?>