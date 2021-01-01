<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Merkha Indonesia</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #f1f1f1;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        input {
            padding: 10pt;
            width: 60%;
            font-size: 15pt;
            border-radius: 5pt;
            border: 1px solid lightgray;
            margin: 10pt;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            width: 60%;
            align-items: center;
            margin: 20pt;
            border: 1px solid lightgray;
            padding: 20pt;
            border-radius: 5pt;
            background: white;
        }
        button {
            border-radius: 5pt;
            padding: 10pt 14pt;
            background: white;
            border: 1px solid gray;
            font-size: 14pt;
            margin: 20pt;
        }
        button:hover {
            background: lightgray;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <form class="form-container" action="api/password/reset" method="POST">
        <h2>Forgot Password?</h2>

        <input name="email" placeholder="Enter email" value="{{request()->get('email')}}">
        <input name="password" placeholder="Enter new password" type="password" id="password" onkeyup='check();'>
        <input name="password_confirmation" placeholder="Confirm new password" type="password" id="confirm_password"  onkeyup='check();'>
        <span id='message'></span>
        <input hidden name="token" placeholder="token" value="{{request()->get('token')}}">

        <button type="submit">Submit</button>
    </form>
</div>
</body>
<script>
    //Check Validation
    var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Password Not Matching';
  }
}
</script>
</html>