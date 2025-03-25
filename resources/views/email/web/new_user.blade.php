<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPT vérification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ffc400;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f4f4f4;
            color: #555555;
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #ffc400;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenu chez Jenos-Food</h1>
        </div>
        <div class="content">
            <p>Cher.e {{$data['nom']}},</p>
            <p>Nous sommes content de vous compter parmi nous!</p>
            <p>Utilisez ces données pour vous connecter : </p>
            <p>
                Email : <b>{{$data['email']}}</b>
            </p>
            <p>
                Mot de passe : <b>{{$data['password']}}</b>
            </p>
            <p>Votre compte a été créé avec succès veillez vous cliquer <a href="https://vue-jenos-food.onrender.com/">ici</a> pour accèder et commencer à gérer !</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Jenos-Food. All rights reserved.</p>
            <p>Kinshasa</p>
        </div>
    </div>
</body>
</html>
