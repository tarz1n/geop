<?php

if (isset($_GET['id'])) {
	$id = '-0-' . trim(strip_tags($_GET['id']));
} else {
	$id = '';
}
?>
<?php include 'includes/layouts/overalheader.php'; ?>

<div class="geo-content">

	<!-- 	<head>

  <link rel="stylesheet" href="https://js.arcgis.com/3.30/esri/css/esri.css">
  <script src="https://js.arcgis.com/3.30/"></script>
  <style>
    html, body, #map {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <script>
    require([
      "esri/map",
      "esri/layers/ArcGISImageServiceLayer",
      "esri/layers/ArcGISTiledMapServiceLayer",
      "esri/geometry/Extent",
      "dojo/domReady!"
    ], function(Map, ArcGISImageServiceLayer, ArcGISTiledMapServiceLayer, Extent) {
      var map = new Map("map", {
        center: [30.5238, 50.4547], 
        zoom: 11
      });

      // Додай шар карти з посиланням на ресурс
      var mapImageLayer = new ArcGISTiledMapServiceLayer("https://map.kyivland.gov.ua/portal/sharing/content/items/ec19e915598b4f1cb956b3a9b9db38bd/data");
      map.addLayer(mapImageLayer);



    });
  </script>
</body> -->

	<head>
		<script src="https://js.arcgis.com/4.23/"></script>
	</head>

	<body>

		<div id="map-geop" style="height: 800px; width: 100%;cursor: pointer"></div>

		<script>
			// Створи об'єкт карти
			require([
				"esri/Map",
				"esri/views/MapView",
				"esri/layers/MapImageLayer"
			], function(Map, MapView, MapImageLayer) {
				// Створи об'єкт карти
				var map = new Map({
					basemap: "streets" // можеш змінити basemap на інший, якщо потрібно
				});

				// Створи об'єкт шару карти з посиланням на ресурс
				var mapImageLayer = new MapImageLayer({
					url: "https://map.kyivland.gov.ua/portal/sharing/rest/content/items/ec19e915598b4f1cb956b3a9b9db38bd/items"
				});

				// Додай шар на карту
				map.add(mapImageLayer);

				// Створи об'єкт відображення карти
				var view = new MapView({
					container: "map-geop", // ідентифікатор div елемента
					map: map,
					center: [30.5238, 50.4547], // координати центру карти (Київ, наприклад)
					zoom: 11, // рівень масштабу
					ui: {
						components: [] // Пустий масив компонентів інтерфейсу для видалення всіх стандартних елементів
					}
				});
			});
		</script>

	</body>



</div>
<?php include 'includes/layouts/footer.php'; ?>