<?php

/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
 **********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR . 'header.inc.php');
?>


<div style="
    width: 100%;
    background: #ffffff;
    border-bottom: 1px solid #e0e0e0;
    padding: 0 20px 20px 0 !important;
    box-sizing: border-box;
    position: relative;
    z-index: 1000;
    clear: both;
    overflow: hidden;
" class="header_wrapper">
    <style>
        @media screen and (max-width: 768px) {
            .top_icons_wrapper {
                flex-direction: row !important;
                justify-content: center !important;
                flex-wrap: wrap !important;
                gap: 10px !important;
            }

            .icons_group_left {
                display: flex !important;
                flex-direction: row !important;
                align-items: center;
                gap: 10px !important;
                flex-wrap: wrap;
                justify-content: center;
            }

            .minister_card {
                padding: 0 !important;
                border: none !important;
                border-radius: 50% !important;
                background: transparent !important;
            }

            .minister_text {
                display: none !important;
            }

            .ai_city_wrapper {
                order: 4;
            }

            .tgdex_wrapper {
                flex-direction: column !important;
                align-items: center !important;
                margin-top: 10px !important;
                text-align: center;
            }

            .tgdex_text {
                display: none;
            }

            .tgdex_wrapper img {
                height: 45px !important;
            }

            .seal_wrapper,
            .minister_img_wrapper,
            .ai_city_wrapper {
                width: 48px !important;
                height: 48px !important;
            }

            .seal_wrapper img,
            .minister_img_wrapper img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover;
                border-radius: 50%;
            }

            .ai_city_wrapper img {
                width: 100% !important;
                height: 100% !important;
            }

            #landing_page {
                flex-direction: column-reverse;
            }

            .main-content_index {
                width: auto;
            }

            .blue.button {}
        }
    </style>

    <div style="max-width: 100%; display: flex; flex-direction: column; gap: 15px;">

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;" class="top_icons_wrapper">
            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;" class="icons_group_left">
                <div style="width: 80px; height: 80px; flex-shrink: 0;" class="seal_wrapper">
                    <img src="/osTicket/assets/default/images/TelenganaGovt-logo.svg" style="width: 100%; height: 100%;">
                </div>

                <div style="display: flex; align-items: center; gap: 10px; background: #ffffff; padding: 0.25rem 0.5rem; padding-right: 3rem; border-radius: 40px; border: 1px solid #d8b167; white-space: nowrap;" class="minister_card cm_card">
                    <div style="width: 72px; height: 72px; border-radius: 50%; overflow: hidden; border: 2px solid #d8b167; flex-shrink: 0;" class="minister_img_wrapper">
                        <img src="/osTicket/assets/default/images/honcm.svg" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="minister_text">
                        <div style="font-size: 1rem; color: #000; font-weight: 700; margin: 0 0 2px 0; line-height: 1;">Hon'ble Chief Minister</div>
                        <div style="font-size: 1rem; color: #333; margin: 0; font-weight: 400; line-height: 1.2;">Sri Anumula Revanth Reddy</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; background: #ffffff; padding: 0.25rem 0.5rem; padding-right: 5rem; border-radius: 40px; border: 1px solid #d8b167; white-space: nowrap;" class="minister_card it_card">
                    <div style="width: 72px; height: 72px; border-radius: 50%; overflow: hidden; border: 2px solid #d8b167; flex-shrink: 0;" class="minister_img_wrapper">
                        <img src="/osTicket/assets/default/images/itmin.svg" style="width: 100%; height: 100%; object-fit: cover;">

                    </div>
                    <div class="minister_text">
                        <div style="font-size: 1rem; color: #000; font-weight: 700; margin: 0 0 2px 0; line-height: 1;">Hon'ble IT Minister</div>
                        <div style="font-size: 1rem; color: #333; margin: 0; font-weight: 400; line-height: 1.2;">Sri D. Sridhar Babu</div>
                    </div>
                </div>
            </div>

            <div style="width: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;" class="ai_city_wrapper">
                <img src="/osTicket/assets/default/images/AI-CITY-Logo.svg" style="width: 80px">
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; min-width: 300px; margin-top: 5px; padding-top: 1rem;" class="tgdex_wrapper">
            <img src="/osTicket/assets/default/images/logo.png" style="height: 46px;">
            <div style="font-size: 52px; color: #212529; font-weight: 400; margin-left: 5px; padding-bottom: 0.6rem" class="tgdex_text">Telangana Data Exchange</div>

        </div>

    </div>
</div>




<div id="landing_page">
    <?php include CLIENTINC_DIR . 'templates/sidebar.tmpl.php'; ?>
    <div class="main-content_index">

        <?php
        if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
            <div class="search-form">
                <form method="get" action="kb/faq.php">
                    <input type="hidden" name="a" value="search" />
                    <input type="text" name="q" class="search" placeholder="<?php echo __('Search our knowledge base'); ?>" />
                    <button type="submit" class="green button"><?php echo __('Search'); ?></button>
                </form>
            </div>
        <?php } ?>
        <div class="thread-body">
            <?php
            if ($cfg && ($page = $cfg->getLandingPage()))
                echo $page->getBodyWithImages();
            else
                echo  '<h1>' . __('Welcome to the Support Center') . '</h1>';
            ?>
        </div>
    </div>
    <!-- <div class="clear"></div> -->

    <div style="display:none">
        <?php
        if ($cfg && $cfg->isKnowledgebaseEnabled()) {
            //FIXME: provide ability to feature or select random FAQs ??
        ?>
            <br /><br />
            <?php
            $cats = Category::getFeatured();
            if ($cats->all()) { ?>
                <h1><?php echo __('Featured Knowledge Base Articles'); ?></h1>
            <?php
            }

            foreach ($cats as $C) { ?>
                <div class="featured-category front-page">
                    <i class="icon-folder-open icon-2x"></i>
                    <div class="category-name">
                        <?php echo $C->getName(); ?>
                    </div>
                    <?php foreach ($C->getTopArticles() as $F) { ?>
                        <div class="article-headline">
                            <div class="article-title"><a href="<?php echo ROOT_PATH;
                                                                ?>kb/faq.php?id=<?php echo $F->getId(); ?>"><?php
                                                                                                            echo $F->getQuestion(); ?></a></div>
                            <div class="article-teaser"><?php echo $F->getTeaser(); ?></div>
                        </div>
                    <?php } ?>
                </div>
        <?php
            }
        }

        ?>

    </div>
</div>

<?php
include CLIENTINC_DIR . 'footer.inc.php';
?>