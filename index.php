<?php

use guzzlehttp\Client;

require __DIR__ . '../vendor/autoload.php';

if (isset($_GET['id'])) {
	$id = '-0-' . trim(strip_tags($_GET['id']));
} else {
	$id = '';
}
?>
<?php include 'includes/layouts/overalheader.php'; ?>

<div class="contentSlider container">
	<div class="slider">
		<div class="slider__wrapper">
			<div class="slider__items">
				<div class="slider__item">
					<div class="slider__item__img">
						<a href="#">
							<img src='images/3-0-12.jpg' alt="Photo">
						</a>
					</div>
					<div class="slider__item__text">
						<a href="#">Запуск системи оцінювання якості обслуговування</a>
					</div>
				</div>
				<div class="slider__item">
					<div class="slider__item__img">
						<a href="#">
							<img src='images/3-0-15.jpg' alt="Photo">
						</a>
					</div>
					<div class="slider__item__text">
						<a href="#">У Києві почала працювати міська геодезична мережа</a>
					</div>
				</div>
				<div class="slider__item">
					<div class="slider__item__img">
						<a href="#">
							<img src='images/3-0-11.jpg' alt="Photo">
						</a>
					</div>
					<div class="slider__item__text">
						<a href="#">Мережа референцних станцій запущена</a>
					</div>
				</div>
			</div>
		</div>
		<a class="slider__control slider__control_prev" href="#" role="button"></a>
		<a class="slider__control slider__control_next slider__control_show" href="#" role="button"></a>
	</div>

	<script src='js/main.js'></script>
	<script>
		slideShow('.slider', {
			isAutoplay: true
		});
	</script>
</div>


<div class="content">
	<!-- 	<div class='news'>
		<h1>Новини</h1>
	</div>

	<div class='announcements'>
		<img src="images/20949942321554373164-128.png">
		<h1>Анонси</h1>
		<div class="text-center">Анонси відсутні!</div>
		<a href="https://geo.kyivland.gov.ua/announces">Переглянути всі анонси</a>
	</div> -->
	<!-- <script>
	const rssUrl = 'https://kyivland.gov.ua/departament/';

// Запит на отримання RSS-стрічки
fetch(rssUrl)
  .then(response => response.text())
  .then(xmlString => {
    // Парсинг XML-даних
    const parser = new DOMParser();
    const xmlDoc = parser.parseFromString(xmlString, 'text/xml');

    // Отримання всіх елементів <item> (новин)
    const items = xmlDoc.querySelectorAll('item');

    // Відображення заголовків новин
    items.forEach(item => {
      const title = item.querySelector('title').textContent;
      console.log(title);
    });
  })
  .catch(error => {
    console.error('Помилка при отриманні RSS-стрічки:', error);
  });
</script> -->

	<script>
		fetch('https://kyivland.gov.ua/newstest.php')
			.then(response => response.text())
			.then(html => {
				const parser = new DOMParser();
				const doc = parser.parseFromString(html, 'text/html');
				console.log(response);
				// Отримуємо елементи з даними
				const id = doc.querySelector('.id').textContent.trim();
				const header = doc.querySelector('.header').textContent.trim();
				const htmlContent = doc.querySelector('.html').innerHTML.trim();
				const description = doc.querySelector('.description').textContent.trim();
				const keywords = doc.querySelector('.keywords').textContent.trim();
				const pic = doc.querySelector('.pic').getAttribute('src').trim();

				// Формуємо об'єкт з отриманими даними
				const data = {
					id: id,
					header: header,
					html: htmlContent,
					description: description,
					keywords: keywords,
					pic: pic
				};

				console.log(data); // Виводимо об'єкт з даними в консоль
			})
			.catch(error => console.error('Помилка отримання даних:', error));
	</script>
	<?php

	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\ServiceProvider;

	function boot()
	{

		$endpoint = "https://kyivland.gov.ua/newstest.php";

		$client = new \GuzzleHttp\Client();


		print "000\n";
		print "111111- ";
		$response = $client->request('GET', $endpoint);
		print "000\n";

		//$statusCode = $response->getStatusCode();

		print "33333";
		$content = $response->getBody() ? json_decode($response->getBody()) : '';

		print "22222";
		if ($content) {

			$lastPostId = $content[0]->id;

			$lastInternalPostId = DB::table('posts')->latest('id')->first();

			if ($lastPostId != $lastInternalPostId->id) {

				foreach ($content as $item) {

					if ($lastPostId == $lastInternalPostId) {
						break;
					}

					$post = new Post();

					$post->id              = $item->id;
					$post->title           = $item->header;
					$post->description     = $item->html;
					$post->seo_title       = $item->header;
					$post->seo_description = $item->description;
					$post->seo_keywords    = $item->keywords;
					$post->image           = $item->pic;
					$post->active          = 1;

					$post->save();
				}
			}
		}
	}
	boot();
	?>




	<?php


	$client = new \GuzzleHttp\Client();
	$response = $client->request('GET', 'https://kyivland.gov.ua/newstest.php');

	print "333";

	echo $response->getStatusCode(); // 200
	echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
	echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

	// Send an asynchronous request.
	$request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
	$promise = $client->sendAsync($request)->then(function ($response) {
		echo 'I completed! ' . $response->getBody();
	});

	$promise->wait();

	?>






	<!-- 	<div class="contentAnnouncement rightCol">
		<div class="announceBlock">
			<div class="page-header">
				<img src='images/20949942321554373164-128.png'>
				<div>Анонси</div>
			</div>
			<?php if (count($announces) > 0) : ?>
				<?php foreach ($announces as $item) : ?>
					<div class="newAnn">
						<a href='announce/' . $item->id">
							<?php echo $item->description; ?>
						</a>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="text-center">Анонси відсутні!</div>
			<?php endif; ?>
			<div class="buttonBlock">
				<a href='front.announces'>Переглянути всі анонси</a>
			</div>
		</div>
		<div class="informBlock">
			<div class="page-header">
				{{-- <img src="{{ asset('images/20933831301581065990-128.png') }}">--}}
				{{-- <div>Інформаційні банери</div>--}}
			</div>
			<div class="bannBlock">
				<div class="bannBlock__item">
					<a href="https://www.president.gov.ua/" target="_blank" rel="nofollow">
						<img src='images/president.png' alt="Сайт президента України" title="Сайт Президента України">
					</a>
				</div>
				<div class="bannBlock__item">
					<a href="https://www.kmu.gov.ua/" target="_blank" rel="nofollow">
						<img src='images/cabmin.png' alt="Кабінет міністрів України" title="Кабінет міністрів України">
					</a>
				</div>
				<div class="bannBlock__item">
					<a href="https://www.rada.gov.ua/" target="_blank" rel="nofollow">
						<img src='images/vru.png' alt="Сайт Верховної Ради України" title="Сайт Верховної Ради України">
					</a>
				</div>

				<div class="bannBlock__item">
					<a href="https://kyivcity.gov.ua/" target="_blank" rel="nofollow">
						<img src='images/kmda.jpg' alt="Сайт Київської міської державної адміністрації" title="Сайт Київської міської державної адміністрації">
					</a>
				</div>
			</div>
		</div>
	</div>-->
</div> 

	<div class="news">
		<div class="title">
			<img src="images/9714387531545304609-128.png">
			<h1>Новини</h1>
		</div>

	</div>

	<div class="announcements">
		<div class="title">
			<img src="images/20949942321554373164-128.png">
			<h1>Анонси</h1>
		</div>
		<div class="text-center">Анонси відсутні!</div>
		<a class="announcement-btn mb20" href="announces.php">Переглянути всі анонси</a>
		<div class="img-links">
			<div class="img-lnk">
				<a class="informLinks mr20 mb10" href="https://www.president.gov.ua/" title="Сайт Президента України"><img src="images/president.png"></a>
			</div>
			<div class="img-lnk">
				<a class="informLinks mb10" href="https://www.kmu.gov.ua/" title="Кабінет міністрів України"><img src="images/cabmin.png"></a>
			</div>
			<div class="img-lnk">
				<a class="informLinks mr20" href="https://www.rada.gov.ua/" title="Сайт Верховної Ради України"><img src="images/vru.png"></a>
			</div>
			<div class="img-lnk">
				<a class="informLinks" href="https://kyivcity.gov.ua/" title="Сайт Київської міської державної адміністрації"><img src="images/kmda.jpg"></a>
			</div>
		</div>

	</div>





</div>




<?php include 'includes/layouts/footer.php'; ?>