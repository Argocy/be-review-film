<!doctype html>
<html>
  <head>
    <meta http-equiv=3D"Content-Type" content=3D"text/html; charset=3DUTF-8">
  </head>
  <body style=3D"font-family: sans-serif;">
    <div style=3D"display: block; margin: auto; max-width: 600px;" class=3D"main">
      <h1 style=3D"font-size: 18px; font-weight: bold; margin-top: 20px">Selamat! {{$name}} Anda Berhasil Melakukan Register</h1>
      <p>untuk melanjutkan proses registrasi,masukan kode otp dibawah ini.</p>
      <h2 style="background-color:lightgreen; text-align: center;" ;>{{$otp}}</h2>
      
      <p>Code otp berlaku selama 5 menit.</p>
    </div>
    <!-- Example of invalid for email html/css, will be detected by Mailtrap: -->
    <style>
      .main { background-color: white; }
      a:hover { border-left-width: 1em; min-height: 2em; }
    </style>
  </body>
</html>