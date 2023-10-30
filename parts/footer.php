<div id="search-modal" class="search-modal">

	<div class="layer"></div>
	<div class="search-modal__inner">
		<button id="search-modal__close" class="modal__close">
			<span class="material-icons-round modal__icon">
				close
			</span>
		</button>
		<div class="modal">
			<form action="/design-chips/search/index.php" method="GET" class="search__form">
				<div class="search__inner">
					<input type="search" name="query" class="search__input"/>
					<button class="search__button">検索</button>
				</div>
				
				<!-- <h2 class="search__heading">ホットワード</h2>
				<div class="search__check-list">
					<div class="search__tag">
						<input type="checkbox" name="" id="item-css" /><label for="item-css">CSS</label>
					</div>
					<div class="search__tag">
						<input type="checkbox" name="" id="item-js" class="search__tag" /><label for="item-js">Jacvascript</label>
					</div>
					<div class="search__tag">
						<input type="checkbox" name="" id="item-php" class="search__tag" /><label for="item-php">PHP</label>
					</div>
					<div class="search__tag">
						<input type="checkbox" name="" id="item-vba" class="search__tag" /><label for="item-vba">VBA(VBE)</label>
					</div>
				</div> -->
			</form>
		</div>
	</div>
	

</div>

<footer>
	<p class="copyright">@Copyright(c) DESIGN CHIPS. All rights reserved</p>
</footer>

<script>
	$('.search__button').on('click', function(event) {
    var searchInput = $('.search__input').val();
    if (searchInput.trim() === "") {
        event.preventDefault(); // フォームの送信を防止
    }
	});
</script>