<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Manager Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        #header {
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 5px 30px 5px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: fit-content;
            /* backdrop-filter: blur(4px); */
            /* background-color: rgba(248, 249, 250, 0.8); */
            background-color: black;
        }

        #header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        #google_translate_element {
            font-size: 1rem;
            float: right;
            width: 100%;
        }

        #google_translate_element select {
            padding: 5px 20px;
            border-radius: 0;
            border: 2px solid white;
            width: 20%;
            background-color: black;
            color: white;
        }

        #google_translate_element select:hover {
            border: 2px solid white;
        }

        .translate-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .translate-btn i {
            margin-right: 5px;
        }
    </style>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                autoDisplay: true
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>

<body>
    <div id="header">
        <div id="google_translate_element"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>