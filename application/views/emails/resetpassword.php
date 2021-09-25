<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8" />

  <title>AdvidsApp | Password Reset</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <style>
     p {Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;
     Margin-bottom: 25px}
     .btn{
        background-color: #f44336; /* red */
        border: none;
        color: #ffffff;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
     }    
   </style>
</head>

<body>

<div>


<p>Hi <?php echo $firstName; ?>,</p>
<p> We have received a request to reset your password for your AdvidsApp account. If you didn't make this request,<br/>
    just ignore this email. Otherwise you can reset your password using this button</p> <a class="btn" href="<?php echo $url; ?>" target="_blank">Reset Password</a><br/>
<p>Thank You</p>
<strong>AdvidsApp</strong>

</div>

</body>

</html>