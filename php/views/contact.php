<h1>Contact</h1>
<div id="contactGrid">
    <div class="column">
        <h2>Vira Vira</h2>
        <h3>Hacienda Hotel</h3>
        <p class="infoRow">Parcela 22a Quetroleufu, Pucón, Chile</p>
        <p class="infoRow">+56 45 237 4000</p>
        <p class="infoRow">info@hotelviravira.com</p>
    </div>
    <form id="contactForm" class="column" action="contact_form" method="post" name="contact">
        <div class="row">
            <div class="column left-align">
                <label for="firstName"></label>
                <input id="firstName" name="firstName" type="text" placeholder="First Name">
            </div>
            <div class="column left-align">
                <label for="lastName"></label>
                <input id="lastName" name="lastName" type="text" placeholder="Last Name">
            </div>
        </div>
        <div class="row">
            <div class="column left-align">
                <label for="email"></label>
                <input id="email" class="firstColumn" name="email" type="text" placeholder="Email">
            </div>
            <div class="column left-align">
                <label for="phone"></label>
                <input id="phone" class="secondColumn" name="phone" type="text" placeholder="Phone Number">
            </div>
        </div>
        <div class="row">
            <div class="column left-align">
                <label for="subject"></label>
                <input id="subject" class="contactForm" name="subject" type="text" placeholder="Subject">
            </div>
        </div>
        <div class="row">
            <div class="column left-align">
                <label for="query"></label>
                <textarea id="query" class="contactForm" name="query"
                          placeholder="We're happy to answer any Questions you may have."></textarea>
            </div>
        </div>
        <div class="row"><input type="submit" value="Ask"></div>
</div>
<img src="/img/howToReachHotel.jpg" alt="Description of how to reach the Hotel" id="route">

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
<script src="/js/contact-validation.js"></script>