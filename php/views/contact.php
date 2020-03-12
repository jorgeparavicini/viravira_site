<h1>Contact</h1>
<div id="contactGrid">
	<div id="leftSide">
		<h2>Vira Vira</h2>
		<h3>Hacienda Hotel</h3>
		<p class="infoRow">Parcela 22a Quetroleufu, Pucón, Chile</p>
		<p class="infoRow">+56 45 237 4000</p>
		<p class="infoRow">info@hotelviravira.com</p>
	</div>
	<form id="rightSide" action="contact_form" method="post">
		<div class="formGrid">
			<label for="firstName"></label>
			<input id="firstName" class="firstColumn" name="firstName" type="text" placeholder="First Name">
			<label for="lastName"></label>
			<input id="lastName" class="secondColumn" name="lastName" type="text" placeholder="Last Name">
		</div>
		<div class="formGrid">
			<label for="email"></label>
			<input id="email" class="firstColumn" name="email" type="email" placeholder="Email">
			<label for="phone"></label>
			<input id="phone" class="secondColumn" name="phone" type="tel" placeholder="Phone Number">
		</div>
		<div class="formGrid">
			<label for="zip"></label>
			<input id="zip" class="firstColumn" name="zip" type="text" placeholder="Zip-Code">
			<label for="fax"></label>
			<input id="fax" class="secondColumn" name="fax" type="text" placeholder="Fax">
		</div>
		<label for="subject"></label>
		<input id="subject" name="subject" type="text" placeholder="Subject">
		<label for="query"></label>
		<textarea id="query" placeholder="We're happy to answer any Questions you may have." minlength="10"
		          maxlength="1000"></textarea>

		<input type="submit" value="Ask">
</div>
<img src="/img/howToReachHotel.jpg" alt="Description of how to reach the Hotel" id="route">