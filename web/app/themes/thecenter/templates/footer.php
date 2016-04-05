<footer class="site-footer" role="contentinfo">

<!--   <section class="newsletter">
    <form action="//fake.us12.list-manage.com/subscribe/post?u=9bc4f1f4827a36c4f3b9e4794&amp;id=7a9de59c95" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
      <h1 class="">Stay up to date with the Center:</h1>
      <label class="visually-hidden" for="mce-EMAIL">Email Address </label>
      <input autofill="off" autocomplete="off" type="email" value="" name="EMAIL" id="mce-EMAIL" placeholder="Enter your email">
      <div style="position: absolute; left: -5000px;"><input type="text" name="b_9bc4f1f4827a36c4f3b9e4794_7a9de59c95" tabindex="-1" value=""></div>
      
      <svg class="icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>
      <button class="submit" type="submit" name="subscribe">Submit</button>
      <div class="newsletter-alert"><span></span> <a href="#" class="close-x"></a></div>
    </form>
  </section> -->

  
  <section class="contact">
    <div class="contact-info">
      <h1>Contact Us:</h1>
      <address class="vcard">
        <span class="adr"><a href="<?= get_option( 'contact_gmaps' ); ?>" target="_blank"><span class="street-address"><?= get_option( 'contact_street' ); ?></span><br>
          <span class="locality"><?= get_option( 'contact_city' ); ?></span>, <span class="region"><?= get_option( 'contact_state' ); ?></span> <span class="postal-code"><?= get_option( 'contact_zip' ); ?></span></a></span><br>
        <span class="tel"><?= get_option( 'contact_phone' ); ?></span><br>
        <span class="email"><a target="_blank" href="mailto:<?= get_option( 'contact_email' ); ?>"><?= get_option( 'contact_email' ); ?></a></span>
      </address>
    </div>
    <div class="logo">
      <svg role="image" class="icon icon-uic"><use xlink:href="#icon-uic"></use></svg>
    </div>
  </section>
</footer>
