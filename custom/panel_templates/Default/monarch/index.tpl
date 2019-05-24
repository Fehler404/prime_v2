{include file='header.tpl'}
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    {include file='navbar.tpl'}
    {include file='sidebar.tpl'}

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{$MONARCH}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{$PANEL_INDEX}">{$DASHBOARD}</a></li>
                            <li class="breadcrumb-item active">{$MONARCH}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {if isset($NEW_UPDATE)}
                {if $NEW_UPDATE_URGENT eq true}
                <div class="alert alert-danger">
                    {else}
                    <div class="alert alert-primary alert-dismissible" id="updateAlert">
                        <button type="button" class="close" id="closeUpdate" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {/if}
                        {$NEW_UPDATE}
                        <br />
                        <a href="{$UPDATE_LINK}" class="btn btn-primary" style="text-decoration:none">{$UPDATE}</a>
                        <hr />
                        {$CURRENT_VERSION}<br />
                        {$NEW_VERSION}
                    </div>
                    {/if}

                    <div class="card">
                        <div class="card-body">
                            {if isset($SUCCESS)}
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5><i class="icon fa fa-check"></i> {$SUCCESS_TITLE}</h5>
                                    {$SUCCESS}
                                </div>
                            {/if}

                            {if isset($ERRORS) && count($ERRORS)}
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> {$ERRORS_TITLE}</h5>
                                    <ul>
                                        {foreach from=$ERRORS item=error}
                                            <li>{$error}</li>
                                        {/foreach}
                                    </ul>
                                </div>
                            {/if}

                                
								
                            <form class='form-group' method='post'>
							<div class="tab-content" id="pills-tabContent">	
							<br>
								<div class="tab-pane fade show active" id="pills-header" role="tabpanel" aria-labelledby="pills-header-tab">
                                <div class="row">
                                <div class="col-md-4">	
									<label for='Theme'>{$NAV_THEME}</label>
									<select id="Theme" class='form-control' name='theme'>
										<option value='#e25d64'{if $NAV_THEME_VALUE eq 'red'} selected{/if}>{$RED}</option>
                                        <option value='#297ba1'{if $NAV_THEME_VALUE eq 'monarch'} selected{/if}>{$MONARCH}</option>
										<option value='darkgreen'{if $NAV_THEME_VALUE eq 'darkgreen'} selected{/if}>{$DARKGREEN}</option>
										<option value='gold'{if $NAV_THEME_VALUE eq 'gold'} selected{/if}>Clearly Yellow</option>
                                        <option value='#f77b4e'{if $NAV_THEME_VALUE eq 'somewhatorange'} selected{/if}>Somewhat Orange</option>
                                        <option value='#f8b88b'{if $NAV_THEME_VALUE eq 'sandpaper'} selected{/if}>Sandpaper</option>
										<option value='rgb(251, 158, 157)'{if $NAV_THEME_VALUE eq 'maybepink'} selected{/if}>Maybe Pink</option>
                                        <option value='#6000ff'{if $NAV_THEME_VALUE eq 'purple2'} selected{/if}>Purple</option>
										<option value='black'{if $NAV_THEME_VALUE eq 'black'} selected{/if}>Just Black</option>
									</select>
                                </div>
                                <div class="col-md-4">
									<label for='bg'>{$HEADER_BG}</label>
									<input type='text' name='bg' value='{$HEADER_BG_VALUE}' class='form-control' placeholder="{$HEADER_BG_PLACEHOLDER}">
                                </div>
                                <div class="col-md-4">
									<label for='logo'>{$LOGO}</label>
									<input type='text' name='logo' value='{$LOGO_VALUE}' class='form-control' placeholder='{$LOGO_PLACEHOLDER}'>
                                </div>
								</div>
                                </div>
                            </div>
								<input type='hidden' name='view' value='update'>
                                <input type="hidden" name="token" value="{$TOKEN}">
                                <button type='submit' class='btn btn-primary'>{$SUBMIT}</button>
                            </form>

                </div>
        </section>
    </div>

    {include file='footer.tpl'}

</div>
<!-- ./wrapper -->

{include file='scripts.tpl'}

</body>
</html>