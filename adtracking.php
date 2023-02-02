



<!DOCTYPE html>
<html lang="en" class="   ">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    
    
    <title>phpwcms/adtracking.php at master · slackero/phpwcms · GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub">
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png">
    <meta property="fb:app_id" content="1401488693436528">

      <meta content="@github" name="twitter:site" /><meta content="summary" name="twitter:card" /><meta content="slackero/phpwcms" name="twitter:title" /><meta content="phpwcms - Flexible, fast, powerful, customer, developer friendly web content management system and cms framework" name="twitter:description" /><meta content="https://avatars0.githubusercontent.com/u/15139?v=2&amp;s=400" name="twitter:image:src" />
<meta content="GitHub" property="og:site_name" /><meta content="object" property="og:type" /><meta content="https://avatars0.githubusercontent.com/u/15139?v=2&amp;s=400" property="og:image" /><meta content="slackero/phpwcms" property="og:title" /><meta content="https://github.com/slackero/phpwcms" property="og:url" /><meta content="phpwcms - Flexible, fast, powerful, customer, developer friendly web content management system and cms framework" property="og:description" />

    <link rel="assets" href="https://assets-cdn.github.com/">
    <link rel="conduit-xhr" href="https://ghconduit.com:25035">
    

    <meta name="msapplication-TileImage" content="/windows-tile.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="selected-link" value="repo_source" data-pjax-transient>
      <meta name="google-analytics" content="UA-3769691-2">

    <meta content="collector.githubapp.com" name="octolytics-host" /><meta content="collector-cdn.github.com" name="octolytics-script-host" /><meta content="github" name="octolytics-app-id" /><meta content="B3D0B953:6A41:11FA81BD:53F3965E" name="octolytics-dimension-request_id" />
    

    
    
    <link rel="icon" type="image/x-icon" href="https://assets-cdn.github.com/favicon.ico">


    <meta content="authenticity_token" name="csrf-param" />
<meta content="2l7Jtn+wNkkmUliXhEJJJIt1T0WXg3yQqMAhdJYzegRmgRLx4C00S4NdDOv74F9ptmBj5STULWDCePid4woHkA==" name="csrf-token" />

    <link href="https://assets-cdn.github.com/assets/github-8007f52df3b93ab70a70e715968762beb348fe31.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://assets-cdn.github.com/assets/github2-ab40800ceeac5bfd40c6948c810e32dbba274dcb.css" media="all" rel="stylesheet" type="text/css" />
    


    <meta http-equiv="x-pjax-version" content="baf75ca89e9940b4a7d7fa71909aa530">

      
  <meta name="description" content="phpwcms - Flexible, fast, powerful, customer, developer friendly web content management system and cms framework">


  <meta content="15139" name="octolytics-dimension-user_id" /><meta content="slackero" name="octolytics-dimension-user_login" /><meta content="4180107" name="octolytics-dimension-repository_id" /><meta content="slackero/phpwcms" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="4180107" name="octolytics-dimension-repository_network_root_id" /><meta content="slackero/phpwcms" name="octolytics-dimension-repository_network_root_nwo" />
  <link href="https://github.com/slackero/phpwcms/commits/master.atom" rel="alternate" title="Recent Commits to phpwcms:master" type="application/atom+xml">

  </head>


  <body class="logged_out  env-production windows vis-public page-blob">
    <a href="#start-of-content" tabindex="1" class="accessibility-aid js-skip-to-content">Skip to content</a>
    <div class="wrapper">
      
      
      
      


      
      <div class="header header-logged-out">
  <div class="container clearfix">

    <a class="header-logo-wordmark" href="https://github.com/">
      <span class="mega-octicon octicon-logo-github"></span>
    </a>

    <div class="header-actions">
        <a class="button primary" href="/join">Sign up</a>
      <a class="button signin" href="/login?return_to=%2Fslackero%2Fphpwcms%2Fblob%2Fmaster%2Fcontent%2Fads%2Fadtracking.php">Sign in</a>
    </div>

    <div class="command-bar js-command-bar  in-repository">

      <ul class="top-nav">
          <li class="explore"><a href="/explore">Explore</a></li>
          <li class="features"><a href="/features">Features</a></li>
          <li class="enterprise"><a href="https://enterprise.github.com/">Enterprise</a></li>
          <li class="blog"><a href="/blog">Blog</a></li>
      </ul>
        <form accept-charset="UTF-8" action="/search" class="command-bar-form" id="top_search_form" method="get"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /></div>

<div class="commandbar">
  <span class="message"></span>
  <input type="text" data-hotkey="s, /" name="q" id="js-command-bar-field" placeholder="Search or type a command" tabindex="1" autocapitalize="off"
    
    
    data-repo="slackero/phpwcms"
  >
  <div class="display hidden"></div>
</div>

    <input type="hidden" name="nwo" value="slackero/phpwcms">

    <div class="select-menu js-menu-container js-select-menu search-context-select-menu">
      <span class="minibutton select-menu-button js-menu-target" role="button" aria-haspopup="true">
        <span class="js-select-button">This repository</span>
      </span>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container" aria-hidden="true">
        <div class="select-menu-modal">

          <div class="select-menu-item js-navigation-item js-this-repository-navigation-item selected">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" class="js-search-this-repository" name="search_target" value="repository" checked="checked">
            <div class="select-menu-item-text js-select-button-text">This repository</div>
          </div> <!-- /.select-menu-item -->

          <div class="select-menu-item js-navigation-item js-all-repositories-navigation-item">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" name="search_target" value="global">
            <div class="select-menu-item-text js-select-button-text">All repositories</div>
          </div> <!-- /.select-menu-item -->

        </div>
      </div>
    </div>

  <span class="help tooltipped tooltipped-s" aria-label="Show command bar help">
    <span class="octicon octicon-question"></span>
  </span>


  <input type="hidden" name="ref" value="cmdform">

</form>
    </div>

  </div>
</div>



      <div id="start-of-content" class="accessibility-aid"></div>
          <div class="site" itemscope itemtype="http://schema.org/WebPage">
    <div id="js-flash-container">
      
    </div>
    <div class="pagehead repohead instapaper_ignore readability-menu">
      <div class="container">
        
<ul class="pagehead-actions">


  <li>
      <a href="/login?return_to=%2Fslackero%2Fphpwcms"
    class="minibutton with-count star-button tooltipped tooltipped-n"
    aria-label="You must be signed in to star a repository" rel="nofollow">
    <span class="octicon octicon-star"></span>
    Star
  </a>

    <a class="social-count js-social-count" href="/slackero/phpwcms/stargazers">
      33
    </a>

  </li>

    <li>
      <a href="/login?return_to=%2Fslackero%2Fphpwcms"
        class="minibutton with-count js-toggler-target fork-button tooltipped tooltipped-n"
        aria-label="You must be signed in to fork a repository" rel="nofollow">
        <span class="octicon octicon-repo-forked"></span>
        Fork
      </a>
      <a href="/slackero/phpwcms/network" class="social-count">
        15
      </a>
    </li>
</ul>

        <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
          <span class="mega-octicon octicon-repo"></span>
          <span class="author"><a href="/slackero" class="url fn" itemprop="url" rel="author"><span itemprop="title">slackero</span></a></span><!--
       --><span class="path-divider">/</span><!--
       --><strong><a href="/slackero/phpwcms" class="js-current-repository js-repo-home-link">phpwcms</a></strong>

          <span class="page-context-loader">
            <img alt="" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
          </span>

        </h1>
      </div><!-- /.container -->
    </div><!-- /.repohead -->

    <div class="container">
      <div class="repository-with-sidebar repo-container new-discussion-timeline  ">
        <div class="repository-sidebar clearfix">
            
<div class="sunken-menu vertical-right repo-nav js-repo-nav js-repository-container-pjax js-octicon-loaders" data-issue-count-url="/slackero/phpwcms/issues/counts">
  <div class="sunken-menu-contents">
    <ul class="sunken-menu-group">
      <li class="tooltipped tooltipped-w" aria-label="Code">
        <a href="/slackero/phpwcms" aria-label="Code" class="selected js-selected-navigation-item sunken-menu-item" data-hotkey="g c" data-pjax="true" data-selected-links="repo_source repo_downloads repo_commits repo_releases repo_tags repo_branches /slackero/phpwcms">
          <span class="octicon octicon-code"></span> <span class="full-word">Code</span>
          <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

        <li class="tooltipped tooltipped-w" aria-label="Issues">
          <a href="/slackero/phpwcms/issues" aria-label="Issues" class="js-selected-navigation-item sunken-menu-item js-disable-pjax" data-hotkey="g i" data-selected-links="repo_issues repo_labels repo_milestones /slackero/phpwcms/issues">
            <span class="octicon octicon-issue-opened"></span> <span class="full-word">Issues</span>
            <span class="js-issue-replace-counter"></span>
            <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>

      <li class="tooltipped tooltipped-w" aria-label="Pull Requests">
        <a href="/slackero/phpwcms/pulls" aria-label="Pull Requests" class="js-selected-navigation-item sunken-menu-item js-disable-pjax" data-hotkey="g p" data-selected-links="repo_pulls /slackero/phpwcms/pulls">
            <span class="octicon octicon-git-pull-request"></span> <span class="full-word">Pull Requests</span>
            <span class="js-pull-replace-counter"></span>
            <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>


        <li class="tooltipped tooltipped-w" aria-label="Wiki">
          <a href="/slackero/phpwcms/wiki" aria-label="Wiki" class="js-selected-navigation-item sunken-menu-item js-disable-pjax" data-hotkey="g w" data-selected-links="repo_wiki /slackero/phpwcms/wiki">
            <span class="octicon octicon-book"></span> <span class="full-word">Wiki</span>
            <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>        </li>
    </ul>
    <div class="sunken-menu-separator"></div>
    <ul class="sunken-menu-group">

      <li class="tooltipped tooltipped-w" aria-label="Pulse">
        <a href="/slackero/phpwcms/pulse/weekly" aria-label="Pulse" class="js-selected-navigation-item sunken-menu-item" data-pjax="true" data-selected-links="pulse /slackero/phpwcms/pulse/weekly">
          <span class="octicon octicon-pulse"></span> <span class="full-word">Pulse</span>
          <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>

      <li class="tooltipped tooltipped-w" aria-label="Graphs">
        <a href="/slackero/phpwcms/graphs" aria-label="Graphs" class="js-selected-navigation-item sunken-menu-item" data-pjax="true" data-selected-links="repo_graphs repo_contributors /slackero/phpwcms/graphs">
          <span class="octicon octicon-graph"></span> <span class="full-word">Graphs</span>
          <img alt="" class="mini-loader" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" width="16" />
</a>      </li>
    </ul>


  </div>
</div>

              <div class="only-with-full-nav">
                
  
<div class="clone-url open"
  data-protocol-type="http"
  data-url="/users/set_protocol?protocol_selector=http&amp;protocol_type=clone">
  <h3><strong>HTTPS</strong> clone URL</h3>
  <div class="input-group">
    <input type="text" class="input-mini input-monospace js-url-field"
           value="https://github.com/slackero/phpwcms.git" readonly="readonly">
    <span class="input-group-button">
      <button aria-label="Copy to clipboard" class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="https://github.com/slackero/phpwcms.git" data-copied-hint="Copied!" type="button"><span class="octicon octicon-clippy"></span></button>
    </span>
  </div>
</div>

  
<div class="clone-url "
  data-protocol-type="subversion"
  data-url="/users/set_protocol?protocol_selector=subversion&amp;protocol_type=clone">
  <h3><strong>Subversion</strong> checkout URL</h3>
  <div class="input-group">
    <input type="text" class="input-mini input-monospace js-url-field"
           value="https://github.com/slackero/phpwcms" readonly="readonly">
    <span class="input-group-button">
      <button aria-label="Copy to clipboard" class="js-zeroclipboard minibutton zeroclipboard-button" data-clipboard-text="https://github.com/slackero/phpwcms" data-copied-hint="Copied!" type="button"><span class="octicon octicon-clippy"></span></button>
    </span>
  </div>
</div>


<p class="clone-options">You can clone with
      <a href="#" class="js-clone-selector" data-protocol="http">HTTPS</a>
      or <a href="#" class="js-clone-selector" data-protocol="subversion">Subversion</a>.
  <a href="https://help.github.com/articles/which-remote-url-should-i-use" class="help tooltipped tooltipped-n" aria-label="Get help on which URL is right for you.">
    <span class="octicon octicon-question"></span>
  </a>
</p>


  <a href="http://windows.github.com" class="minibutton sidebar-button" title="Save slackero/phpwcms to your computer and use it in GitHub Desktop." aria-label="Save slackero/phpwcms to your computer and use it in GitHub Desktop.">
    <span class="octicon octicon-device-desktop"></span>
    Clone in Desktop
  </a>

                <a href="/slackero/phpwcms/archive/master.zip"
                   class="minibutton sidebar-button"
                   aria-label="Download slackero/phpwcms as a zip file"
                   title="Download slackero/phpwcms as a zip file"
                   rel="nofollow">
                  <span class="octicon octicon-cloud-download"></span>
                  Download ZIP
                </a>
              </div>
        </div><!-- /.repository-sidebar -->

        <div id="js-repo-pjax-container" class="repository-content context-loader-container" data-pjax-container>
          

<a href="/slackero/phpwcms/blob/05e5fa3c84b2be93d19ecde891e72cf6ecdafe3d/content/ads/adtracking.php" class="hidden js-permalink-shortcut" data-hotkey="y">Permalink</a>

<!-- blob contrib key: blob_contributors:v21:a002ccb4806a11b517dceb000e629821 -->

<div class="file-navigation">
  
<div class="select-menu js-menu-container js-select-menu left">
  <span class="minibutton select-menu-button js-menu-target css-truncate" data-hotkey="w"
    data-master-branch="master"
    data-ref="master"
    title="master"
    role="button" aria-label="Switch branches or tags" tabindex="0" aria-haspopup="true">
    <span class="octicon octicon-git-branch"></span>
    <i>branch:</i>
    <span class="js-select-button css-truncate-target">master</span>
  </span>

  <div class="select-menu-modal-holder js-menu-content js-navigation-container" data-pjax aria-hidden="true">

    <div class="select-menu-modal">
      <div class="select-menu-header">
        <span class="select-menu-title">Switch branches/tags</span>
        <span class="octicon octicon-x js-menu-close" role="button" aria-label="Close"></span>
      </div> <!-- /.select-menu-header -->

      <div class="select-menu-filters">
        <div class="select-menu-text-filter">
          <input type="text" aria-label="Filter branches/tags" id="context-commitish-filter-field" class="js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
        </div>
        <div class="select-menu-tabs">
          <ul>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="branches" class="js-select-menu-tab">Branches</a>
            </li>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="tags" class="js-select-menu-tab">Tags</a>
            </li>
          </ul>
        </div><!-- /.select-menu-tabs -->
      </div><!-- /.select-menu-filters -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="branches">

        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item selected">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/slackero/phpwcms/blob/master/content/ads/adtracking.php"
                 data-name="master"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="master">master</a>
            </div> <!-- /.select-menu-item -->
        </div>

          <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="tags">
        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/slackero/phpwcms/tree/phpwcms-1.7.4/content/ads/adtracking.php"
                 data-name="phpwcms-1.7.4"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="phpwcms-1.7.4">phpwcms-1.7.4</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/slackero/phpwcms/tree/phpwcms-1.7.2/content/ads/adtracking.php"
                 data-name="phpwcms-1.7.2"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="phpwcms-1.7.2">phpwcms-1.7.2</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/slackero/phpwcms/tree/phpwcms-1.6.531/content/ads/adtracking.php"
                 data-name="phpwcms-1.6.531"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="phpwcms-1.6.531">phpwcms-1.6.531</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/slackero/phpwcms/tree/phpwcms-1.6.529/content/ads/adtracking.php"
                 data-name="phpwcms-1.6.529"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="phpwcms-1.6.529">phpwcms-1.6.529</a>
            </div> <!-- /.select-menu-item -->
            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <a href="/slackero/phpwcms/tree/phpwcms-1.5.3/content/ads/adtracking.php"
                 data-name="phpwcms-1.5.3"
                 data-skip-pjax="true"
                 rel="nofollow"
                 class="js-navigation-open select-menu-item-text css-truncate-target"
                 title="phpwcms-1.5.3">phpwcms-1.5.3</a>
            </div> <!-- /.select-menu-item -->
        </div>

        <div class="select-menu-no-results">Nothing to show</div>
      </div> <!-- /.select-menu-list -->

    </div> <!-- /.select-menu-modal -->
  </div> <!-- /.select-menu-modal-holder -->
</div> <!-- /.select-menu -->

  <div class="button-group right">
    <a href="/slackero/phpwcms/find/master"
          class="js-show-file-finder minibutton empty-icon tooltipped tooltipped-s"
          data-pjax
          data-hotkey="t"
          aria-label="Quickly jump between files">
      <span class="octicon octicon-list-unordered"></span>
    </a>
    <button class="js-zeroclipboard minibutton zeroclipboard-button"
          data-clipboard-text="content/ads/adtracking.php"
          aria-label="Copy to clipboard"
          data-copied-hint="Copied!">
      <span class="octicon octicon-clippy"></span>
    </button>
  </div>

  <div class="breadcrumb">
    <span class='repo-root js-repo-root'><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/slackero/phpwcms" class="" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">phpwcms</span></a></span></span><span class="separator"> / </span><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/slackero/phpwcms/tree/master/content" class="" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">content</span></a></span><span class="separator"> / </span><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/slackero/phpwcms/tree/master/content/ads" class="" data-branch="master" data-direction="back" data-pjax="true" itemscope="url"><span itemprop="title">ads</span></a></span><span class="separator"> / </span><strong class="final-path">adtracking.php</strong>
  </div>
</div>


  <div class="commit file-history-tease">
      <img alt="Oliver Georgi" class="main-avatar" data-user="15139" height="24" src="https://avatars0.githubusercontent.com/u/15139?v=2&amp;s=48" width="24" />
      <span class="author"><a href="/slackero" rel="author">slackero</a></span>
      <time datetime="2014-08-19T09:20:42+02:00" is="relative-time">August 19, 2014</time>
      <div class="commit-title">
          <a href="/slackero/phpwcms/commit/05e5fa3c84b2be93d19ecde891e72cf6ecdafe3d" class="message" data-pjax="true" title="Preparations for issue #55">Preparations for issue</a> <a href="https://github.com/slackero/phpwcms/issues/55" class="issue-link" title="MySQL Improved Extension Support">#55</a>
      </div>

    <div class="participation">
      <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>1</strong>  contributor</a></p>
      

    </div>
    <div id="blob_contributors_box" style="display:none">
      <h2 class="facebox-header">Users who have contributed to this file</h2>
      <ul class="facebox-user-list">
          <li class="facebox-user-list-item">
            <img alt="Oliver Georgi" data-user="15139" height="24" src="https://avatars0.githubusercontent.com/u/15139?v=2&amp;s=48" width="24" />
            <a href="/slackero">slackero</a>
          </li>
      </ul>
    </div>
  </div>

<div class="file-box">
  <div class="file">
    <div class="meta clearfix">
      <div class="info file-name">
          <span>75 lines (57 sloc)</span>
          <span class="meta-divider"></span>
        <span>2.478 kb</span>
      </div>
      <div class="actions">
        <div class="button-group">
          <a href="/slackero/phpwcms/raw/master/content/ads/adtracking.php" class="minibutton " id="raw-url">Raw</a>
            <a href="/slackero/phpwcms/blame/master/content/ads/adtracking.php" class="minibutton js-update-url-with-hash">Blame</a>
          <a href="/slackero/phpwcms/commits/master/content/ads/adtracking.php" class="minibutton " rel="nofollow">History</a>
        </div><!-- /.button-group -->

          <a class="octicon-button tooltipped tooltipped-nw"
             href="http://windows.github.com" aria-label="Open this file in GitHub for Windows">
              <span class="octicon octicon-device-desktop"></span>
          </a>

            <a class="octicon-button disabled tooltipped tooltipped-w" href="#"
               aria-label="You must be signed in to make or propose changes"><span class="octicon octicon-pencil"></span></a>

          <a class="octicon-button danger disabled tooltipped tooltipped-w" href="#"
             aria-label="You must be signed in to make or propose changes">
          <span class="octicon octicon-trashcan"></span>
        </a>
      </div><!-- /.actions -->
    </div>
      
  <div class="blob-wrapper data type-php">
      <table class="highlight tab-size-8 js-file-line-container">
      <tr>
        <td id="L1" class="blob-line-num js-line-number" data-line-number="1"></td>
        <td id="LC1" class="blob-line-code js-file-line"><span class="o">&lt;?</span><span class="nx">php</span></td>
      </tr>
      <tr>
        <td id="L2" class="blob-line-num js-line-number" data-line-number="2"></td>
        <td id="LC2" class="blob-line-code js-file-line"><span class="sd">/**</span></td>
      </tr>
      <tr>
        <td id="L3" class="blob-line-num js-line-number" data-line-number="3"></td>
        <td id="LC3" class="blob-line-code js-file-line"><span class="sd"> * phpwcms content management system</span></td>
      </tr>
      <tr>
        <td id="L4" class="blob-line-num js-line-number" data-line-number="4"></td>
        <td id="LC4" class="blob-line-code js-file-line"><span class="sd"> *</span></td>
      </tr>
      <tr>
        <td id="L5" class="blob-line-num js-line-number" data-line-number="5"></td>
        <td id="LC5" class="blob-line-code js-file-line"><span class="sd"> * @author Oliver Georgi &lt;oliver@phpwcms.de&gt;</span></td>
      </tr>
      <tr>
        <td id="L6" class="blob-line-num js-line-number" data-line-number="6"></td>
        <td id="LC6" class="blob-line-code js-file-line"><span class="sd"> * @copyright Copyright (c) 2002-2014, Oliver Georgi</span></td>
      </tr>
      <tr>
        <td id="L7" class="blob-line-num js-line-number" data-line-number="7"></td>
        <td id="LC7" class="blob-line-code js-file-line"><span class="sd"> * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2</span></td>
      </tr>
      <tr>
        <td id="L8" class="blob-line-num js-line-number" data-line-number="8"></td>
        <td id="LC8" class="blob-line-code js-file-line"><span class="sd"> * @link http://www.phpwcms.de</span></td>
      </tr>
      <tr>
        <td id="L9" class="blob-line-num js-line-number" data-line-number="9"></td>
        <td id="LC9" class="blob-line-code js-file-line"><span class="sd"> *</span></td>
      </tr>
      <tr>
        <td id="L10" class="blob-line-num js-line-number" data-line-number="10"></td>
        <td id="LC10" class="blob-line-code js-file-line"><span class="sd"> **/</span></td>
      </tr>
      <tr>
        <td id="L11" class="blob-line-num js-line-number" data-line-number="11"></td>
        <td id="LC11" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L12" class="blob-line-num js-line-number" data-line-number="12"></td>
        <td id="LC12" class="blob-line-code js-file-line"><span class="c1">// tracking pixel</span></td>
      </tr>
      <tr>
        <td id="L13" class="blob-line-num js-line-number" data-line-number="13"></td>
        <td id="LC13" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L14" class="blob-line-num js-line-number" data-line-number="14"></td>
        <td id="LC14" class="blob-line-code js-file-line"><span class="nv">$phpwcms</span>				<span class="o">=</span> <span class="k">array</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L15" class="blob-line-num js-line-number" data-line-number="15"></td>
        <td id="LC15" class="blob-line-code js-file-line"><span class="nv">$phpwcms</span><span class="p">[</span><span class="s1">&#39;THIS_ROOT&#39;</span><span class="p">]</span>	<span class="o">=</span> <span class="nb">realpath</span><span class="p">(</span><span class="nb">dirname</span><span class="p">(</span><span class="k">__FILE__</span><span class="p">)</span><span class="o">.</span><span class="s1">&#39;/../../&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L16" class="blob-line-num js-line-number" data-line-number="16"></td>
        <td id="LC16" class="blob-line-code js-file-line"><span class="k">require</span><span class="p">(</span><span class="nv">$phpwcms</span><span class="p">[</span><span class="s1">&#39;THIS_ROOT&#39;</span><span class="p">]</span><span class="o">.</span><span class="s1">&#39;/config/phpwcms/conf.inc.php&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L17" class="blob-line-num js-line-number" data-line-number="17"></td>
        <td id="LC17" class="blob-line-code js-file-line"><span class="k">require</span><span class="p">(</span><span class="nv">$phpwcms</span><span class="p">[</span><span class="s1">&#39;THIS_ROOT&#39;</span><span class="p">]</span><span class="o">.</span><span class="s1">&#39;/include/inc_lib/default.inc.php&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L18" class="blob-line-num js-line-number" data-line-number="18"></td>
        <td id="LC18" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L19" class="blob-line-num js-line-number" data-line-number="19"></td>
        <td id="LC19" class="blob-line-code js-file-line"><span class="c1">// first check</span></td>
      </tr>
      <tr>
        <td id="L20" class="blob-line-num js-line-number" data-line-number="20"></td>
        <td id="LC20" class="blob-line-code js-file-line"><span class="k">if</span><span class="p">(</span><span class="o">!</span><span class="k">empty</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;t&#39;</span><span class="p">])</span> <span class="o">&amp;&amp;</span> <span class="nb">isset</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;u&#39;</span><span class="p">])</span> <span class="o">&amp;&amp;</span> <span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;u&#39;</span><span class="p">]</span> <span class="o">==</span> <span class="nx">PHPWCMS_USER_KEY</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L21" class="blob-line-num js-line-number" data-line-number="21"></td>
        <td id="LC21" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L22" class="blob-line-num js-line-number" data-line-number="22"></td>
        <td id="LC22" class="blob-line-code js-file-line">	<span class="nv">$ads</span> <span class="o">=</span> <span class="nb">explode</span><span class="p">(</span><span class="s1">&#39;,&#39;</span><span class="p">,</span> <span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;t&#39;</span><span class="p">]);</span></td>
      </tr>
      <tr>
        <td id="L23" class="blob-line-num js-line-number" data-line-number="23"></td>
        <td id="LC23" class="blob-line-code js-file-line">	<span class="nv">$ads</span> <span class="o">=</span> <span class="nb">array_map</span><span class="p">(</span><span class="s1">&#39;intval&#39;</span><span class="p">,</span> <span class="nv">$ads</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L24" class="blob-line-num js-line-number" data-line-number="24"></td>
        <td id="LC24" class="blob-line-code js-file-line">	<span class="nv">$ads</span> <span class="o">=</span> <span class="nb">array_diff</span><span class="p">(</span><span class="nv">$ads</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="mi">0</span><span class="p">));</span></td>
      </tr>
      <tr>
        <td id="L25" class="blob-line-num js-line-number" data-line-number="25"></td>
        <td id="LC25" class="blob-line-code js-file-line">	<span class="nv">$ads</span> <span class="o">=</span> <span class="nb">array_unique</span><span class="p">(</span><span class="nv">$ads</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L26" class="blob-line-num js-line-number" data-line-number="26"></td>
        <td id="LC26" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L27" class="blob-line-num js-line-number" data-line-number="27"></td>
        <td id="LC27" class="blob-line-code js-file-line">	<span class="k">if</span><span class="p">(</span><span class="nb">count</span><span class="p">(</span><span class="nv">$ads</span><span class="p">))</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L28" class="blob-line-num js-line-number" data-line-number="28"></td>
        <td id="LC28" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L29" class="blob-line-num js-line-number" data-line-number="29"></td>
        <td id="LC29" class="blob-line-code js-file-line">		<span class="k">require</span><span class="p">(</span><span class="nx">PHPWCMS_ROOT</span><span class="o">.</span><span class="s1">&#39;/include/inc_lib/dbcon.inc.php&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L30" class="blob-line-num js-line-number" data-line-number="30"></td>
        <td id="LC30" class="blob-line-code js-file-line">		<span class="k">require</span><span class="p">(</span><span class="nx">PHPWCMS_ROOT</span><span class="o">.</span><span class="s1">&#39;/include/inc_lib/general.inc.php&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L31" class="blob-line-num js-line-number" data-line-number="31"></td>
        <td id="LC31" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L32" class="blob-line-num js-line-number" data-line-number="32"></td>
        <td id="LC32" class="blob-line-code js-file-line">		<span class="nv">$ads_userip</span>		<span class="o">=</span> <span class="nx">getRemoteIP</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L33" class="blob-line-num js-line-number" data-line-number="33"></td>
        <td id="LC33" class="blob-line-code js-file-line">		<span class="nv">$ads_useragent</span>	<span class="o">=</span> <span class="nv">$_SERVER</span><span class="p">[</span><span class="s1">&#39;HTTP_USER_AGENT&#39;</span><span class="p">];</span></td>
      </tr>
      <tr>
        <td id="L34" class="blob-line-num js-line-number" data-line-number="34"></td>
        <td id="LC34" class="blob-line-code js-file-line">		<span class="nv">$ads_ref</span>		<span class="o">=</span> <span class="nb">isset</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;r&#39;</span><span class="p">])</span> <span class="o">?</span> <span class="nb">trim</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;r&#39;</span><span class="p">])</span> <span class="o">:</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L35" class="blob-line-num js-line-number" data-line-number="35"></td>
        <td id="LC35" class="blob-line-code js-file-line">		<span class="nv">$ads_cat</span>		<span class="o">=</span> <span class="k">empty</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;c&#39;</span><span class="p">])</span> <span class="o">?</span> <span class="mi">0</span> <span class="o">:</span> <span class="nb">intval</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;c&#39;</span><span class="p">]);</span></td>
      </tr>
      <tr>
        <td id="L36" class="blob-line-num js-line-number" data-line-number="36"></td>
        <td id="LC36" class="blob-line-code js-file-line">		<span class="nv">$ads_article</span>	<span class="o">=</span> <span class="k">empty</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;a&#39;</span><span class="p">])</span> <span class="o">?</span> <span class="mi">0</span> <span class="o">:</span> <span class="nb">intval</span><span class="p">(</span><span class="nv">$_GET</span><span class="p">[</span><span class="s1">&#39;a&#39;</span><span class="p">]);</span></td>
      </tr>
      <tr>
        <td id="L37" class="blob-line-num js-line-number" data-line-number="37"></td>
        <td id="LC37" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L38" class="blob-line-num js-line-number" data-line-number="38"></td>
        <td id="LC38" class="blob-line-code js-file-line">		<span class="k">if</span><span class="p">(</span><span class="k">empty</span><span class="p">(</span><span class="nv">$_COOKIE</span><span class="p">[</span><span class="s1">&#39;phpwcmsAdsUserId&#39;</span><span class="p">])</span> <span class="o">||</span> <span class="o">!</span><span class="nb">preg_match</span><span class="p">(</span><span class="s1">&#39;/^[0-9a-f]{32}$/&#39;</span><span class="p">,</span> <span class="p">(</span><span class="nv">$ads_userid</span> <span class="o">=</span> <span class="nv">$_COOKIE</span><span class="p">[</span><span class="s1">&#39;phpwcmsAdsUserId&#39;</span><span class="p">])</span> <span class="p">)</span> <span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L39" class="blob-line-num js-line-number" data-line-number="39"></td>
        <td id="LC39" class="blob-line-code js-file-line">			<span class="nv">$ads_userid</span>	<span class="o">=</span> <span class="nb">md5</span><span class="p">(</span><span class="nv">$ads_userip</span><span class="o">.</span><span class="nb">microtime</span><span class="p">());</span></td>
      </tr>
      <tr>
        <td id="L40" class="blob-line-num js-line-number" data-line-number="40"></td>
        <td id="LC40" class="blob-line-code js-file-line">			<span class="nb">setcookie</span><span class="p">(</span><span class="s1">&#39;phpwcmsAdsUserId&#39;</span><span class="p">,</span> <span class="nv">$ads_userid</span><span class="p">,</span> <span class="nb">time</span><span class="p">()</span><span class="o">+</span><span class="mi">63072000</span><span class="p">,</span> <span class="s1">&#39;/&#39;</span><span class="p">,</span> <span class="nx">getCookieDomain</span><span class="p">()</span> <span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L41" class="blob-line-num js-line-number" data-line-number="41"></td>
        <td id="LC41" class="blob-line-code js-file-line">		<span class="p">}</span></td>
      </tr>
      <tr>
        <td id="L42" class="blob-line-num js-line-number" data-line-number="42"></td>
        <td id="LC42" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L43" class="blob-line-num js-line-number" data-line-number="43"></td>
        <td id="LC43" class="blob-line-code js-file-line">		<span class="nv">$t</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L44" class="blob-line-num js-line-number" data-line-number="44"></td>
        <td id="LC44" class="blob-line-code js-file-line">		<span class="k">foreach</span><span class="p">(</span><span class="nv">$ads</span> <span class="k">as</span> <span class="nv">$value</span><span class="p">)</span> <span class="p">{</span></td>
      </tr>
      <tr>
        <td id="L45" class="blob-line-num js-line-number" data-line-number="45"></td>
        <td id="LC45" class="blob-line-code js-file-line">			<span class="nv">$t</span><span class="p">[]</span> <span class="o">=</span> <span class="s2">&quot;(NOW(), &quot;</span><span class="o">.</span><span class="nv">$value</span><span class="o">.</span><span class="s2">&quot;, &quot;</span><span class="o">.</span><span class="nx">_dbEscape</span><span class="p">(</span><span class="nv">$ads_userip</span><span class="p">)</span><span class="o">.</span><span class="s2">&quot;, &quot;</span><span class="o">.</span><span class="nx">_dbEscape</span><span class="p">(</span><span class="nv">$ads_userid</span><span class="p">)</span><span class="o">.</span><span class="s2">&quot;, &quot;</span><span class="o">.</span></td>
      </tr>
      <tr>
        <td id="L46" class="blob-line-num js-line-number" data-line-number="46"></td>
        <td id="LC46" class="blob-line-code js-file-line">				   <span class="s2">&quot;0, 1, &quot;</span><span class="o">.</span><span class="nx">_dbEscape</span><span class="p">(</span><span class="nv">$ads_useragent</span><span class="p">)</span><span class="o">.</span><span class="s2">&quot;, &quot;</span><span class="o">.</span><span class="nx">_dbEscape</span><span class="p">(</span><span class="nv">$ads_ref</span><span class="p">)</span><span class="o">.</span><span class="s2">&quot;, &quot;</span><span class="o">.</span><span class="nv">$ads_cat</span><span class="o">.</span><span class="s2">&quot;, &quot;</span><span class="o">.</span><span class="nv">$ads_article</span><span class="o">.</span><span class="s2">&quot;)&quot;</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L47" class="blob-line-num js-line-number" data-line-number="47"></td>
        <td id="LC47" class="blob-line-code js-file-line">		<span class="p">}</span></td>
      </tr>
      <tr>
        <td id="L48" class="blob-line-num js-line-number" data-line-number="48"></td>
        <td id="LC48" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L49" class="blob-line-num js-line-number" data-line-number="49"></td>
        <td id="LC49" class="blob-line-code js-file-line">		<span class="nv">$sql</span>  <span class="o">=</span>	<span class="s1">&#39;INSERT DELAYED INTO &#39;</span><span class="o">.</span><span class="nx">DB_PREPEND</span><span class="o">.</span><span class="s1">&#39;phpwcms_ads_tracking (&#39;</span><span class="o">.</span></td>
      </tr>
      <tr>
        <td id="L50" class="blob-line-num js-line-number" data-line-number="50"></td>
        <td id="LC50" class="blob-line-code js-file-line">				<span class="s1">&#39;adtracking_created, adtracking_campaignid, adtracking_ip, adtracking_cookieid, &#39;</span><span class="o">.</span></td>
      </tr>
      <tr>
        <td id="L51" class="blob-line-num js-line-number" data-line-number="51"></td>
        <td id="LC51" class="blob-line-code js-file-line">				<span class="s1">&#39;adtracking_countclick, adtracking_countview, adtracking_useragent, adtracking_ref, &#39;</span><span class="o">.</span></td>
      </tr>
      <tr>
        <td id="L52" class="blob-line-num js-line-number" data-line-number="52"></td>
        <td id="LC52" class="blob-line-code js-file-line">				<span class="s1">&#39;adtracking_catid, adtracking_articleid) VALUES &#39;</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L53" class="blob-line-num js-line-number" data-line-number="53"></td>
        <td id="LC53" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L54" class="blob-line-num js-line-number" data-line-number="54"></td>
        <td id="LC54" class="blob-line-code js-file-line">		<span class="nv">$sql</span> <span class="o">.=</span> <span class="nb">implode</span><span class="p">(</span><span class="s1">&#39;,&#39;</span><span class="p">,</span> <span class="nv">$t</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L55" class="blob-line-num js-line-number" data-line-number="55"></td>
        <td id="LC55" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L56" class="blob-line-num js-line-number" data-line-number="56"></td>
        <td id="LC56" class="blob-line-code js-file-line">		<span class="o">@</span><span class="nx">_dbQuery</span><span class="p">(</span><span class="nv">$sql</span><span class="p">,</span> <span class="s1">&#39;INSERT&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L57" class="blob-line-num js-line-number" data-line-number="57"></td>
        <td id="LC57" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L58" class="blob-line-num js-line-number" data-line-number="58"></td>
        <td id="LC58" class="blob-line-code js-file-line">		<span class="nv">$sql</span>  <span class="o">=</span> <span class="s1">&#39;UPDATE LOW_PRIORITY &#39;</span><span class="o">.</span><span class="nx">DB_PREPEND</span><span class="o">.</span><span class="s1">&#39;phpwcms_ads_campaign SET &#39;</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L59" class="blob-line-num js-line-number" data-line-number="59"></td>
        <td id="LC59" class="blob-line-code js-file-line">		<span class="nv">$sql</span> <span class="o">.=</span> <span class="s1">&#39;adcampaign_curview=adcampaign_curview+1 &#39;</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L60" class="blob-line-num js-line-number" data-line-number="60"></td>
        <td id="LC60" class="blob-line-code js-file-line">		<span class="nv">$sql</span> <span class="o">.=</span> <span class="s1">&#39;WHERE adcampaign_id IN(&#39;</span><span class="o">.</span><span class="nb">implode</span><span class="p">(</span><span class="s1">&#39;,&#39;</span><span class="p">,</span> <span class="nv">$ads</span><span class="p">)</span><span class="o">.</span><span class="s1">&#39;)&#39;</span><span class="p">;</span></td>
      </tr>
      <tr>
        <td id="L61" class="blob-line-num js-line-number" data-line-number="61"></td>
        <td id="LC61" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L62" class="blob-line-num js-line-number" data-line-number="62"></td>
        <td id="LC62" class="blob-line-code js-file-line">		<span class="o">@</span><span class="nx">_dbQuery</span><span class="p">(</span><span class="nv">$sql</span><span class="p">,</span> <span class="s1">&#39;UPDATE&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L63" class="blob-line-num js-line-number" data-line-number="63"></td>
        <td id="LC63" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L64" class="blob-line-num js-line-number" data-line-number="64"></td>
        <td id="LC64" class="blob-line-code js-file-line">	<span class="p">}</span></td>
      </tr>
      <tr>
        <td id="L65" class="blob-line-num js-line-number" data-line-number="65"></td>
        <td id="LC65" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L66" class="blob-line-num js-line-number" data-line-number="66"></td>
        <td id="LC66" class="blob-line-code js-file-line"><span class="p">}</span></td>
      </tr>
      <tr>
        <td id="L67" class="blob-line-num js-line-number" data-line-number="67"></td>
        <td id="LC67" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L68" class="blob-line-num js-line-number" data-line-number="68"></td>
        <td id="LC68" class="blob-line-code js-file-line"><span class="c1">// return blank gif image 1x1 pixel</span></td>
      </tr>
      <tr>
        <td id="L69" class="blob-line-num js-line-number" data-line-number="69"></td>
        <td id="LC69" class="blob-line-code js-file-line"><span class="nb">header</span><span class="p">(</span><span class="s1">&#39;Cache-Control: no-cache, must-revalidate&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L70" class="blob-line-num js-line-number" data-line-number="70"></td>
        <td id="LC70" class="blob-line-code js-file-line"><span class="nb">header</span><span class="p">(</span><span class="s1">&#39;Expires: Mon, 26 Jul 1997 05:00:00 GMT&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L71" class="blob-line-num js-line-number" data-line-number="71"></td>
        <td id="LC71" class="blob-line-code js-file-line"><span class="nb">header</span><span class="p">(</span><span class="s1">&#39;Content-type: image/gif&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L72" class="blob-line-num js-line-number" data-line-number="72"></td>
        <td id="LC72" class="blob-line-code js-file-line"><span class="k">echo</span> <span class="nb">base64_decode</span><span class="p">(</span><span class="s1">&#39;R0lGODlhAQABAPAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==&#39;</span><span class="p">);</span></td>
      </tr>
      <tr>
        <td id="L73" class="blob-line-num js-line-number" data-line-number="73"></td>
        <td id="LC73" class="blob-line-code js-file-line"><span class="k">exit</span><span class="p">();</span></td>
      </tr>
      <tr>
        <td id="L74" class="blob-line-num js-line-number" data-line-number="74"></td>
        <td id="LC74" class="blob-line-code js-file-line">
</td>
      </tr>
      <tr>
        <td id="L75" class="blob-line-num js-line-number" data-line-number="75"></td>
        <td id="LC75" class="blob-line-code js-file-line"><span class="cp">?&gt;</span><span class="x"></span></td>
      </tr>
</table>

  </div>

  </div>
</div>

<a href="#jump-to-line" rel="facebox[.linejump]" data-hotkey="l" style="display:none">Jump to Line</a>
<div id="jump-to-line" style="display:none">
  <form accept-charset="UTF-8" class="js-jump-to-line-form">
    <input class="linejump-input js-jump-to-line-field" type="text" placeholder="Jump to line&hellip;" autofocus>
    <button type="submit" class="button">Go</button>
  </form>
</div>

        </div>

      </div><!-- /.repo-container -->
      <div class="modal-backdrop"></div>
    </div><!-- /.container -->
  </div><!-- /.site -->


    </div><!-- /.wrapper -->

      <div class="container">
  <div class="site-footer">
    <ul class="site-footer-links right">
      <li><a href="https://status.github.com/">Status</a></li>
      <li><a href="http://developer.github.com">API</a></li>
      <li><a href="http://training.github.com">Training</a></li>
      <li><a href="http://shop.github.com">Shop</a></li>
      <li><a href="/blog">Blog</a></li>
      <li><a href="/about">About</a></li>

    </ul>

    <a href="/" aria-label="Homepage">
      <span class="mega-octicon octicon-mark-github" title="GitHub"></span>
    </a>

    <ul class="site-footer-links">
      <li>&copy; 2014 <span title="0.02473s from github-fe132-cp1-prd.iad.github.net">GitHub</span>, Inc.</li>
        <li><a href="/site/terms">Terms</a></li>
        <li><a href="/site/privacy">Privacy</a></li>
        <li><a href="/security">Security</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
  </div><!-- /.site-footer -->
</div><!-- /.container -->


    <div class="fullscreen-overlay js-fullscreen-overlay" id="fullscreen_overlay">
  <div class="fullscreen-container js-suggester-container">
    <div class="textarea-wrap">
      <textarea name="fullscreen-contents" id="fullscreen-contents" class="fullscreen-contents js-fullscreen-contents js-suggester-field" placeholder=""></textarea>
    </div>
  </div>
  <div class="fullscreen-sidebar">
    <a href="#" class="exit-fullscreen js-exit-fullscreen tooltipped tooltipped-w" aria-label="Exit Zen Mode">
      <span class="mega-octicon octicon-screen-normal"></span>
    </a>
    <a href="#" class="theme-switcher js-theme-switcher tooltipped tooltipped-w"
      aria-label="Switch themes">
      <span class="octicon octicon-color-mode"></span>
    </a>
  </div>
</div>



    <div id="ajax-error-message" class="flash flash-error">
      <span class="octicon octicon-alert"></span>
      <a href="#" class="octicon octicon-x close js-ajax-error-dismiss" aria-label="Dismiss error"></a>
      Something went wrong with that request. Please try again.
    </div>


      <script crossorigin="anonymous" src="https://assets-cdn.github.com/assets/frameworks-12d5fda141e78e513749dddbc56445fe172cbd9a.js" type="text/javascript"></script>
      <script async="async" crossorigin="anonymous" src="https://assets-cdn.github.com/assets/github-7248813d9ffe2d35cee5c253018812117761e865.js" type="text/javascript"></script>
      
      
        <script async src="https://www.google-analytics.com/analytics.js"></script>
  </body>
</html>

