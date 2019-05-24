<div class="ui fluid card" id="widget-online-staff">
  <div class="content">
    <h4 class="ui header">{$ONLINE_STAFF}</h4>
    <div class="description">
      {if isset($ONLINE_STAFF_LIST)}
        {foreach from=$ONLINE_STAFF_LIST name=online_staff_arr item=user}
          <div class="ui relaxed list">
            <div class="item">
              <a href="{$user.profile}" data-poload="{$USER_INFO_URL}{$user.id}"><img class="ui mini image" src="{$user.avatar}" alt="{$user.username}"></a>
              <!--<div class="content">
                <a class="header" href="{$user.profile}" data-poload="{$USER_INFO_URL}{$user.id}" style="{$user.style|replace:';':''}!important;">{$user.nickname}</a>
                {if $user.title}{$user.title}{else}{$user.group}{/if}
              </div>-->
            </div>
          </div>
        {/foreach}
      {else}
        {$NO_STAFF_ONLINE}
      {/if}
    </div>
  </div>
  <div class="extra content">
    {$TOTAL_ONLINE_STAFF}
  </div>
</div>