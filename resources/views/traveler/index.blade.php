<!DOCTYPE html>
<html>
<head>
    <title>Application</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="container">
        <div id="app">
            <div>Средний рейтинг = {{ $average_rating }}</div>
            Топ путешественник: {{$highest_rating->name}} - рейтинг {{$highest_rating->sum_rating}}
            <data-viewer source="/api/traveler" title="Traveler Data" />
        </div>
    </div>
</body>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</html>