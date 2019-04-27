  </div></div>
  <div class="ui vertical footer segment" id="footer">
  <div id="contact" class="contact-section section text-center">
    <div class="container">
        <h2 class="section-title">Contact us</h2>
        <div class="section-intro center-block">Feel free to contact our team if you have any question or suggestion.</div>
        <div class="contact-block center-block">
            <div class="row">

                <div class="item col-xs-12 col-md-4">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="fa fa-microphone"></i>
                        </div><!--//icon-holder-->
                        <h4 class="title">Teamspeak</h4>
                        <div class="email"><a target="_blank" href="ts3server://#">example.com</a></div>
                    </div><!--//item-inner-->
                </div><!--//item-->

                <div class="item col-xs-12 col-md-4">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="fa fa-envelope"></i>
                        </div><!--//icon-holder-->
                        <h4 class="title">Support</h4>
                        <div class="email"><a href="#">Support</a></div>
                    </div><!--//item-inner-->
                </div><!--//item-->

                <div class="item col-xs-12 col-md-4">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="fa fa-headphones"></i>
                        </div><!--//icon-holder-->
                        <h4 class="title">Discord</h4>
                        <div class="email"><a target="_blank" href="#">example</a></div>
                    </div><!--//item-inner-->
                </div><!--//item-->


            </div><!--//row-->
        </div><!--//contact-list-->
        <div class="social-media-block">
            <ul class="list-inline social-media-list">
			<span class="item">&copy; {$SITE_NAME} {'Y'|date}</span><br>
        {foreach from=$SOCIAL_MEDIA_ICONS item=icon}
				<a href="{$icon.link}" target="_blank"><i id="social-{$icon.short}" class="{if $icon.long neq 'envelope'}fab{else}fas{/if} fa-{$icon.long}-square fa-3x social"></i></a>
			  {/foreach}
            </ul>
        </div><!--//social-media-block-->
		<div class="row">
		<div class="col-md-6">
          <div class="ui inverted link list">
            <span class="item">Powered By <a href="https://namelessmc.com">NamelessMC</a></span>
            <span class="item">Template By <a href="https://www.spigotmc.org/members/spiele.25346/">Spiele</a></span>
          </div>
        </div>
		<div class="col-md-6">
          <div class="ui inverted link list">
            <span class="item"><a href="{$TERMS_LINK}">{$TERMS_TEXT}</a></span>
            <span class="item"><a href="{$PRIVACY_LINK}">{$PRIVACY_TEXT}</a></span>
          </div>
        </div>
		</div>
    </div><!--//containter-->
</div>
  </div>

  {if isset($GLOBAL_WARNING_TITLE)}
    <div class="ui medium modal" id="modal-acknowledge">
      <div class="header">
        {$GLOBAL_WARNING_TITLE}
      </div>
      <div class="content">
        {$GLOBAL_WARNING_REASON}
      </div>
      <div class="actions">
        <a class="ui positive button" href="{$GLOBAL_WARNING_ACKNOWLEDGE_LINK}">{$GLOBAL_WARNING_ACKNOWLEDGE}</a>
      </div>
    </div>
  {/if}

  {foreach from=$TEMPLATE_JS item=script}
    {$script}
  {/foreach}
  <script src="{$TEMPLATE.path}/js/bootstrap.min.js"></script>

  {if isset($NEW_UPDATE) && ($NEW_UPDATE_URGENT != true)}
    <script src="{$TEMPLATE.path}/js/core/update.js"></script>
  {/if}

</body>

</html>
