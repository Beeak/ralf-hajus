<html>
<head>
    <title>Edit Marker</title>
</head>
<body>
    <h1>Edit Marker</h1>
    <form method="POST" action="/markers/{{ $marker->id }}">
        @csrf
        @method('PUT')
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="{{ $marker->name }}"><br>
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" value="{{ $marker->description }}"><br>
        <label for="latitude">Latitude:</label><br>
        <input type="text" id="latitude" name="latitude" value="{{ $marker->latitude }}"><br>
        <label for="longitude">Longitude:</label><br>
        <input type="text" id="longitude" name="longitude" value="{{ $marker->longitude }}"><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>