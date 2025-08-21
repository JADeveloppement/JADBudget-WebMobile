<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de contact</title>
</head>
<body>
    <style>
        .container {
            width: fit-content;
            height: fit-content;
            border-radius: 10px;
            border-style: solid;
            border-color: orange;
            border-width: 2px;
            background: #FFAF0050 ;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .container > span {
            font-size: 1.25rem;
            color: darkOrange;
            font-weight: bold;
            padding: 0rem;
            padding-bottom: 1.2rem;
        }

        a {
            width: 100%;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            color: black;
        }

        a:hover {
            text-decoration: underline;
        }
        
    </style>
    <div class="container">
        <span>Formulaire de contact</span>
        <a href="mailto:{{$recipient}}">{{$recipient}}</a>
    </div>
</body>
</html>