<?php include_once THEMES . Settings::getTheme() . '/plugins/generic-header.tpl'; ?>
                  <!-- NEWS LIST START -->
                  <div class="center-news-whole-page">
                  <?php foreach($tpl->news as $news) { ?>
                  <div class="center-news-whole">
                    <div class="center-news-title">
                      <h1><?php echo $news['title']; ?></h1>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="center-news-subtitle-left">
                          &nbsp;
                        </td>
                        <td class="center-news-subtitle-center">
                          <div class="center-news-subtitle-center-date">
                            <img src="<?php echo THEMES . Settings::getTheme() . '/images/date.png'; ?>" />
                          </div>&nbsp;
                          <?php echo date('d-m-Y, H:i', $news['date']); ?>
                          <div class="center-news-subtitle-center-author">
                            Автор: <?php echo $news['author_name']; ?>
                          </div>
                        </td>
                        <td class="center-news-subtitle-right">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                    <div class="center-news-body">
                      <?php echo $news['body']; ?>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr valign="middle">
                        <td class="center-news-bar-left">
                          &nbsp;
                        </td>
                        <td class="center-news-bar-center">
                          <div>
                            Комментариев: (<?php echo $news['comments_count']; ?>)
                          </div>
                        </td>
                        <td class="center-news-bar-right">
                          <a href="<?php echo Settings::getAddressSite() . 'news/more/' . $news['id']; ?>">
                            <div class="news-read-more-left">
                              
                            </div>
                            <div class="news-read-more-center">
                              <div style="margin-top: 4px;">
                              <b>Читать далее</b>
                              </div>
                            </div>
                            <div class="news-read-more-right">
                              &nbsp;
                            </div>
                          </a>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="center-news-hsep">
                    &nbsp;
                  </div>
                  <?php } ?>
                  <div class="center-news-pager">
                    <?php if($tpl->page) { ?>
                    <a href="<?php echo Settings::getAddressSite() . 'news/index/page/' . $tpl->page; ?>">&#8592 Позже</a>
                    <?php } ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if ($tpl->page * $tpl->per_page + $tpl->per_page < $tpl->news_count) { ?>
                    <a href="<?php echo Settings::getAddressSite() . 'news/index/page/' . ($tpl->page + 2); ?>">Раньше &#8594</a>
                    <?php } ?>
                  </div>
                  </div>
                  <!-- NEWS LIST END -->
<?php include_once THEMES . Settings::getTheme() . '/plugins/generic-footer.tpl'; ?>

