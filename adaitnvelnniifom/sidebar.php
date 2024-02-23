<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">WELCOME TO ADMIN PANEL</li>
            <li  class="treeview <?php if($pageType=='HomePage') { echo 'active'; }?>">
              <a href="index.php">
                <i class="fa fa-home"></i> <span>Home</span> 
              </a>
            </li>
            <li class="treeview <?php if(strpos($pageType, 'Product') !== false) { echo 'class="active"'; } ?>">
              <a href="#">
                <i class="fa fa-suitcase"></i> <span>Short Form</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <!-- <li <?php if($pageType=='Product') { echo 'class="active"'; } ?>><a href="addproduct.php?dataType=Product"><i class="fa fa-plus-circle"></i> Add Product</a></li>
                <li <?php if($pageType=='Sub Product') { echo 'class="active"'; } ?>><a href="add_subproduct.php?dataType=SubProduct"><i class="fa fa-plus-circle"></i>Add Subproduct</a></li> -->
                <li <?php if($pageType=='Short Form') { echo 'class="active"'; } ?>><a href="add_shortform.php?dataType=ShortForm"><i class="fa fa-plus-circle"></i>Add Short Form</a></li>
                <!--<li <?php if($pageType=='gstRateFinder') { echo 'class="active"'; } ?>><a href="gstRateFinder.php?dataType=GstRateFinder"><i class="fa fa-plus-circle"></i>Add Gst Rate Finder</a></li>-->
              </ul>
            </li>
			 <li class="treeview <?php if(strpos($pageType, 'GstRateFinder') !== false) { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-calculator"></i> <span>Gst Rate Finder</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'GstRateFinder') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-search"></i> View GstRateFinder</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='GstRateFinderservices') { echo 'class="active"'; } ?>><a href="viewGstRateFinderservices.php"><i class="fa fa-search"></i> Services</a></li>
                    <li <?php if($pageType=='GstRateFindergoods') { echo 'class="active"'; } ?>><a href="viewGstRateFindergoods"><i class="fa fa-search"></i> Goods</a></li>
                    <li <?php if($pageType=='GstRateFinderhsn') { echo 'class="active"'; } ?>><a href="viewGstRateFinderhsn.php"><i class="fa fa-search"></i> HSN Code</a></li>
                  </ul>
                </li>

                <li <?php if(strpos($pageType, 'addGstRateFinder') !== false) { echo 'class="active"'; } ?>><a href="#"><i class="fa fa-plus-circle"></i> Add GstRateFinder</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='addGstRateFinderservices') { echo 'class="active"'; } ?>><a href="addGstRateFinder.php?dataType=services"><i class="fa fa-plus-circle"></i> Services</a></li>
                    <li <?php if($pageType=='addGstRateFindergoods') { echo 'class="active"'; } ?>><a href="addGstRateFinder.php?dataType=goods"><i class="fa fa-plus-circle"></i> Goods</a></li>
                    <li <?php if($pageType=='addGstRateFinderhsn') { echo 'class="active"'; } ?>><a href="addGstRateFinder.php?dataType=hsn"><i class="fa fa-plus-circle"></i> HSN Code</a></li>
                  </ul>
                </li>
                
                <li <?php if(strpos($pageType, 'GSTCouncilMeeting') !== false) { echo 'class="active"'; } ?>><a href="#"><i class="fa fa-plus-circle"></i>GST Resources</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='GSTCouncilMeetingAddChapter') { echo 'class="active"'; } ?>><a href="add_gst_council_meeting_chapter.php"><i class="fa fa-plus-circle"></i>Add C/M Chapter</a></li>
                    <li <?php if($pageType=='GSTCouncilMeetingListChapter') { echo 'class="active"'; } ?>><a href="gst_council_meeting_chapter_list.php"><i class="fa fa-plus-circle"></i>C/M Chapter List</a></li>
                    <li <?php if($pageType=='AddGSTCouncilMeeting') { echo 'class="active"'; } ?>><a href="add_gst_council_meeting.php"><i class="fa fa-plus-circle"></i>Add C/M</a></li>
                    <li <?php if($pageType=='ListGSTCouncilMeeting') { echo 'class="active"'; } ?>><a href="gst_council_meeting_list.php"><i class="fa fa-plus-circle"></i>C/M List</a></li>
                  </ul>
                </li>
              </ul>
            </li>
			
            <li class="treeview <?php if(strpos($pageType, 'COIArticle') !== false) { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-bank"></i> <span>COI Articles</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'COIArticle') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Chapters</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='COIArticleListChapter') { echo 'class="active"'; } ?>><a href="COI_ChapterList.php"><i class="fa fa-plus-circle"></i>List Chapters</a></li>
                    <li <?php if($pageType=='COIArticleAddChapter') { echo 'class="active"'; } ?>><a href="COI_ChapterAdd.php"><i class="fa fa-plus-circle"></i> Add Chapter</a></li>
                    <li <?php if($pageType=='COIArticleListArticles') { echo 'class="active"'; } ?>><a href="COI_ArticleList.php"><i class="fa fa-plus-circle"></i>List Articles</a></li>
                    <li <?php if($pageType=='COIArticleAddArticle') { echo 'class="active"'; } ?>><a href="COI_ArticleAdd.php"><i class="fa fa-plus-circle"></i> Add Article</a></li>
                  </ul>
                </li>
                <li <?php if($pageType=='COIArticleUpdatePremble') { echo 'class="active"'; } ?>><a href="COI_UpdatePreamble.php"><i class="fa fa-plus-circle"></i>Update Other Info</a></li>
              </ul>
            </li>
            <li class="treeview <?php if(strpos($pageType, 'COISection') !== false) { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-gavel"></i> <span>ACT Sections</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'COISection') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Chapters</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='COISectionListChapter') { echo 'class="active"'; } ?>><a href="COI_Section_ChapterList.php"><i class="fa fa-plus-circle"></i>List Section Chapter</a></li>
                    <li <?php if($pageType=='COISectionAddChapter') { echo 'class="active"'; } ?>><a href="COI_Section_ChapterAdd.php"><i class="fa fa-plus-circle"></i>Add Section Chapter</a></li>
                    <li <?php if($pageType=='COISectionListSection') { echo 'class="active"'; } ?>><a href="COI_SectionList.php"><i class="fa fa-plus-circle"></i>List Section</a></li>
                    <li <?php if($pageType=='COISectionAddSection') { echo 'class="active"'; } ?>><a href="COI_SectionAdd.php"><i class="fa fa-plus-circle"></i> Add Section</a></li>                  
                  </ul>
                </li>
                <li <?php if($pageType=='COIArticleUpdatePremble') { echo 'class="active"'; } ?>><a href="COI_UpdatePreamble.php"><i class="fa fa-plus-circle"></i>Update Other Info</a></li>
              </ul>
            </li>
            <li class="treeview <?php if(strpos($pageType, 'ArchiveCases') !== false || $pageType=='addMultipleCaseData') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-suitcase"></i> <span>Archive Cases</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'viewArchiveCases') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-search"></i> View Cases</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='viewArchiveCasesAll') { echo 'class="active"'; } ?>><a href="viewArchiveCaseAllData.php"><i class="fa fa-search"></i> All Cases</a></li>
                    <li <?php if($pageType=='viewArchiveCasesvat') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=vat"><i class="fa fa-search"></i> VAT</a></li>
                    <li <?php if($pageType=='viewArchiveCasesst') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=st"><i class="fa fa-search"></i> Service Tax</a></li>
                    <li <?php if($pageType=='viewArchiveCasesce') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=ce"><i class="fa fa-search"></i> Central Excise</a></li>
                    <li <?php if($pageType=='viewArchiveCasescu') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=cu"><i class="fa fa-search"></i> Customs</a></li>
                    <li <?php if($pageType=='viewArchiveCasesdgft') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=dgft"><i class="fa fa-search"></i> DGFT</a></li>
                    <li <?php if($pageType=='viewArchiveCasesgst') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=gst"><i class="fa fa-search"></i> GST</a></li>
                    <li <?php if($pageType=='viewArchiveCasessgst') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=sgst"><i class="fa fa-search"></i> SGST</a></li>
                    <li <?php if($pageType=='viewArchiveCasesutgst') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=utgst"><i class="fa fa-search"></i> UTGST</a></li>
                    <li <?php if($pageType=='viewArchiveCasesigst') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=igst"><i class="fa fa-search"></i> IGST</a></li>
                    <li <?php if($pageType=='viewArchiveCasescgst') { echo 'class="active"'; } ?>><a href="viewArchiveCaseData.php?dataType=cgst"><i class="fa fa-search"></i> CGST</a></li>
                    <li <?php if($pageType=='viewGSTNotications') { echo 'class="active"'; } ?>><a href="viewGSTNotications.php?dataType=cgst"><i class="fa fa-search"></i> GST Notifications</a></li>
                  </ul>
                </li>
                <li <?php if(strpos($pageType, 'addArchiveCases') !== false) { echo 'class="active"'; } ?>><a href="#"><i class="fa fa-plus-circle"></i> Add Cases</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='addArchiveCasesvat') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=vat"><i class="fa fa-plus-circle"></i> VAT</a></li>
                    <li <?php if($pageType=='addArchiveCasesst') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=st"><i class="fa fa-plus-circle"></i> Service Tax</a></li>
                    <li <?php if($pageType=='addArchiveCasesce') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=ce"><i class="fa fa-plus-circle"></i> Central Excise</a></li>
                    <li <?php if($pageType=='addArchiveCasescu') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=cu"><i class="fa fa-plus-circle"></i> Customs</a></li>
                    <li <?php if($pageType=='addArchiveCasesdgft') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=dgft"><i class="fa fa-plus-circle"></i> DGFT</a></li>
                    <li <?php if($pageType=='addArchiveCasesgst') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=gst"><i class="fa fa-plus-circle"></i> GST</a></li>
                    <li <?php if($pageType=='addArchiveCasessgst') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=sgst"><i class="fa fa-plus-circle"></i> SGST</a></li>
                    <li <?php if($pageType=='addArchiveCasesutgst') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=utgst"><i class="fa fa-plus-circle"></i> UTGST</a></li>
                    <li <?php if($pageType=='addArchiveCasesigst') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=igst"><i class="fa fa-plus-circle"></i> IGST</a></li>
                    <li <?php if($pageType=='addArchiveCasescgst') { echo 'class="active"'; } ?>><a href="addArchiveCaseData.php?dataType=cgst"><i class="fa fa-plus-circle"></i> CGST</a></li>
                    <li <?php if($pageType=='addGSTNotiCSV') { echo 'class="active"'; } ?>><a href="addGSTNotiCSV.php"><i class="fa fa-plus-circle"></i> GST Notifications</a></li>
                  </ul>
                </li>
                <li <?php if($pageType=='addMultipleCaseData') { echo 'class="active"'; } ?>><a href="addMultipleCaseData.php"><i class="fa fa-plus-circle"></i> Add Multiple Cases</a></li>
               </ul>
            </li>
            <li class="treeview <?php if(strpos($pageType, 'RecentCases') !== false) { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-newspaper-o"></i> <span>Recent Cases</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'viewRecentCases') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-search"></i> View Cases</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='viewRecentCasesAll') { echo 'class="active"'; } ?>><a href="viewRecentCaseAllData.php"><i class="fa fa-search"></i> All Cases</a></li>
                    <li <?php if($pageType=='viewRecentCasesvat') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=vat"><i class="fa fa-search"></i> VAT</a></li>
                    <li <?php if($pageType=='viewRecentCasesst') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=st"><i class="fa fa-search"></i> Service Tax</a></li>
                    <li <?php if($pageType=='viewRecentCasesce') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=ce"><i class="fa fa-search"></i> Central Excise</a></li>
                    <li <?php if($pageType=='viewRecentCasescu') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=cu"><i class="fa fa-search"></i> Customs</a></li>
                    <li <?php if($pageType=='viewRecentCasesdgft') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=dgft"><i class="fa fa-search"></i> DGFT</a></li>
                    <li <?php if($pageType=='viewRecentCasesgst') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=gst"><i class="fa fa-search"></i> GST</a></li>                    
                    <li <?php if($pageType=='viewRecentCasessgst') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=sgst"><i class="fa fa-search"></i> SGST</a></li>
                    <li <?php if($pageType=='viewRecentCasesutgst') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=utgst"><i class="fa fa-search"></i> UTGST</a></li>
                    <li <?php if($pageType=='viewRecentCasesigst') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=igst"><i class="fa fa-search"></i> IGST</a></li>
                    <li <?php if($pageType=='viewRecentCasescgst') { echo 'class="active"'; } ?>><a href="viewRecentCaseData.php?dataType=cgst"><i class="fa fa-search"></i> CGST</a></li>

                  </ul>
                </li>
                <!-- <li <?php if(strpos($pageType, 'addRecentCases') !== false) { echo 'class="active"'; } ?>><a href="#"><i class="fa fa-plus-circle"></i> Add Cases</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='addRecentCasesvat') { echo 'class="active"'; } ?>><a href="addRecentCaseData.php?dataType=vat"><i class="fa fa-plus-circle"></i> VAT</a></li>
                    <li <?php if($pageType=='addRecentCasesst') { echo 'class="active"'; } ?>><a href="addRecentCaseData.php?dataType=st"><i class="fa fa-plus-circle"></i> Service Tax</a></li>
                    <li <?php if($pageType=='addRecentCasesce') { echo 'class="active"'; } ?>><a href="addRecentCaseData.php?dataType=ce"><i class="fa fa-plus-circle"></i> Central Excise</a></li>
                    <li <?php if($pageType=='addRecentCasescu') { echo 'class="active"'; } ?>><a href="addRecentCaseData.php?dataType=cu"><i class="fa fa-plus-circle"></i> Customs</a></li>
                    <li <?php if($pageType=='addRecentCasesdgft') { echo 'class="active"'; } ?>><a href="addRecentCaseData.php?dataType=dgft"><i class="fa fa-plus-circle"></i> DGFT</a></li>
                    <li <?php if($pageType=='addRecentCasesgst') { echo 'class="active"'; } ?>><a href="addRecentCaseData.php?dataType=gst"><i class="fa fa-plus-circle"></i> GST</a></li>
                  </ul>
                </li> -->
               </ul>
            </li>
            
            <li class="treeview <?php if(strpos($pageType, 'MappingData') !== false) { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-bank"></i> <span>Mapping Data</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'MappingData') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Mapping</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='ListMappingData') { echo 'class="active"'; } ?>><a href="mapping_data_list.php"><i class="fa fa-plus-circle"></i>List Mapping Data</a></li>
                    <li <?php if($pageType=='AddMappingData') { echo 'class="active"'; } ?>><a href="add_mapping_data.php"><i class="fa fa-plus-circle"></i> Add Mapping Data</a></li>
                  </ul>
                </li>
                
                <li <?php if(strpos($pageType, 'MappingCaseCirculars') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Case Circulars</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='ListMappingCaseCirculars') { echo 'class="active"'; } ?>><a href="mapping_case_circulars_list.php"><i class="fa fa-plus-circle"></i>List Case Circulars</a></li>
                    <li <?php if($pageType=='AddMappingCaseCirculars') { echo 'class="active"'; } ?>><a href="add_mapping_case_circulars.php"><i class="fa fa-plus-circle"></i> Add Case Circulars</a></li>
                  </ul>
                </li>
                
                <li <?php if(strpos($pageType, 'MappingCaseCites') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Case Cites</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='ListMappingCaseCites') { echo 'class="active"'; } ?>><a href="mapping_case_cites_list.php"><i class="fa fa-plus-circle"></i>List Case Cites</a></li>
                    <li <?php if($pageType=='AddMappingCaseCites') { echo 'class="active"'; } ?>><a href="add_mapping_case_cites.php"><i class="fa fa-plus-circle"></i> Add Case Cites</a></li>
                  </ul>
                </li>
                
                <li <?php if(strpos($pageType, 'MappingCaseNotifications') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Case Notifications</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='ListMappingCaseNotifications') { echo 'class="active"'; } ?>><a href="mapping_case_notifications_list.php"><i class="fa fa-plus-circle"></i>List Notifications</a></li>
                    <li <?php if($pageType=='AddMappingCaseNotifications') { echo 'class="active"'; } ?>><a href="add_mapping_case_notifications.php"><i class="fa fa-plus-circle"></i> Add Notifications</a></li>
                  </ul>
                </li>
                
                <li <?php if(strpos($pageType, 'MappingCaseRules') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Case Rules</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='ListMappingCaseRules') { echo 'class="active"'; } ?>><a href="mapping_case_rules_list.php"><i class="fa fa-plus-circle"></i>List Rules</a></li>
                    <li <?php if($pageType=='AddMappingCaseRules') { echo 'class="active"'; } ?>><a href="add_mapping_case_rules.php"><i class="fa fa-plus-circle"></i> Add Rules</a></li>
                  </ul>
                </li>

                <!--<li <?php if(strpos($pageType, 'MappingCaseSections') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Case Sections</a>-->
                <!--  <ul class="treeview-menu">-->
                <!--    <li <?php if($pageType=='ListMappingCaseSections') { echo 'class="active"'; } ?>><a href="mapping_case_sections_list.php"><i class="fa fa-plus-circle"></i>List Sections</a></li>-->
                <!--    <li <?php if($pageType=='AddMappingCaseSections') { echo 'class="active"'; } ?>><a href="add_mapping_case_sections.php"><i class="fa fa-plus-circle"></i> Add Sections</a></li>-->
                <!--  </ul>-->
                <!--</li>-->
                
              </ul>
            </li>
            
            <li class="treeview <?php if(strpos($pageType, 'Menu') !== false) { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-file"></i> <span>Menu</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'Menu') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-plus-circle"></i>Menu</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='ListMenu') { echo 'class="active"'; } ?>><a href="menu_list.php"><i class="fa fa-plus-circle"></i>List Menu</a></li>
                    <li <?php if($pageType=='AddMappingData') { echo 'class="active"'; } ?>><a href="add_menu.php"><i class="fa fa-plus-circle"></i> Add Menu</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            
            <li class="treeview <?php if($pageType=='addSearchCategory') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Search Category</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='addSearchCategory') { echo 'class="active"'; } ?>><a href="addSearchCategory.php"><i class="fa fa-search"></i>Add Search Category</a></li>
                <li <?php if($pageType=='addArticle') { echo 'class="active"'; } ?>><a href="addArticleData.php"><i class="fa fa-plus-circle"></i> Add Articles</a></li>
                <li <?php if($pageType=='List_search_history') { echo 'class="active"'; } ?>><a href="viewSearchHistoryList.php"><i class="fa fa-plus-circle"></i> View Search History </a></li>
                <li <?php if($pageType=='List_search_history') { echo 'class="active"'; } ?>><a href="viewSearchHistoryList2.php"><i class="fa fa-plus-circle"></i> View Search History2 </a></li>
                <li <?php if(strpos($pageType, 'sidebararticles') !== false) { echo 'class="active"'; }?>><a href="sidebarSettings.php?type=articles"><i class="fa fa-th-large"></i> Sidebar widget</a></li>
               </ul>
            </li>

            <li class="treeview <?php if(strpos($pageType, 'Budget') !== false || $pageType=='sidebarbudgets_analysis') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-bank"></i> <span>Budget</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(strpos($pageType, 'UnionBudgets') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-table"></i> Union Budget</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='viewUnionBudgetsData') { echo 'class="active"'; } ?>><a href="viewUnionBudgetsData.php"><i class="fa fa-search"></i> View Union Budget</a></li>
                    <li <?php if($pageType=='addUnionBudgetsData') { echo 'class="active"'; } ?>><a href="addUnionBudgetsData.php"><i class="fa fa-plus-circle"></i> Add Union Budget</a></li>                    
                  </ul>
                </li>
                <li <?php if(strpos($pageType, 'StateBudgets') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-legal"></i> State Budget</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='viewStateBudgetsData') { echo 'class="active"'; } ?>><a href="viewStateBudgetsData.php"><i class="fa fa-search"></i> View State Budget</a></li>
                    <li <?php if($pageType=='addStateBudgetsData') { echo 'class="active"'; } ?>><a href="addStateBudgetsData.php"><i class="fa fa-plus-circle"></i> Add State Budget</a></li>                    
                  </ul>
                </li>
                <li <?php if(strpos($pageType, 'BudgetAnalysis') !== false) { echo 'class="active"'; }?>><a href="#"><i class="fa fa-map"></i> Budget Analysis</a>
                  <ul class="treeview-menu">
                    <li <?php if($pageType=='viewBudgetAnalysisData') { echo 'class="active"'; } ?>><a href="viewBudgetAnalysisData.php"><i class="fa fa-search"></i> View Budget Analysis</a></li>                    
                    <li <?php if($pageType=='addBudgetAnalysisData') { echo 'class="active"'; } ?>><a href="addBudgetAnalysisData.php"><i class="fa fa-plus-circle"></i> Add Budget Analysis</a></li>
                  </ul>
                </li>
                <li <?php if(strpos($pageType, 'updateBudgetBanner') !== false) { echo 'class="active"'; }?>><a href="updateBudgetBanner.php"><i class="fa fa-th-large"></i> Budget Banner</a></li>
                <li <?php if(strpos($pageType, 'sidebarbudgets_analysis') !== false) { echo 'class="active"'; }?>><a href="sidebarSettings.php?type=budgets_analysis"><i class="fa fa-th-large"></i> Sidebar widget</a></li>
              </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewTaxvista'|| $pageType=='addTaxVista' || $pageType=='sidebartaxvista') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-file-text-o"></i> <span>Tax Vista</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewTaxvista') { echo 'class="active"'; } ?>><a href="viewTaxVista.php"><i class="fa fa-search"></i> View Tax Vista</a></li>
                <li <?php if($pageType=='addTaxVista') { echo 'class="active"'; } ?>><a href="addTaxVista.php"><i class="fa fa-plus-circle"></i> Add Tax Vista</a></li>
                <li <?php if(strpos($pageType, 'sidebartaxvista') !== false) { echo 'class="active"'; }?>><a href="sidebarSettings.php?type=taxvista"><i class="fa fa-th-large"></i> Sidebar widget</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewArticles'|| $pageType=='addArticle' || $pageType=='sidebararticles') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Articles</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewArticles') { echo 'class="active"'; } ?>><a href="viewArticlesData.php"><i class="fa fa-search"></i> View Articles</a></li>
                <li <?php if($pageType=='addArticle') { echo 'class="active"'; } ?>><a href="addArticleData.php"><i class="fa fa-plus-circle"></i> Add Articles</a></li>
                <li <?php if(strpos($pageType, 'sidebararticles') !== false) { echo 'class="active"'; }?>><a href="sidebarSettings.php?type=articles"><i class="fa fa-th-large"></i> Sidebar widget</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewFeatures'|| $pageType=='addFeature' || $pageType=='sidebarfeatures') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-list-alt"></i> <span>Features</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewFeatures') { echo 'class="active"'; } ?>><a href="viewFeaturesData.php"><i class="fa fa-search"></i> View Features</a></li>
                <li <?php if($pageType=='addFeature') { echo 'class="active"'; } ?>><a href="addFeatureData.php"><i class="fa fa-plus-circle"></i> Add Features</a></li>
                <li <?php if(strpos($pageType, 'sidebarfeatures') !== false) { echo 'class="active"'; }?>><a href="sidebarSettings.php?type=features"><i class="fa fa-th-large"></i> Sidebar widget</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewSchedules' || $pageType=='addSchedule') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-server"></i> <span>Schedules</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewSchedules') { echo 'class="active"'; } ?>><a href="viewSchedulesData.php"><i class="fa fa-search"></i> View Schedues</a></li>
                <li <?php if($pageType=='addSchedule') { echo 'class="active"'; } ?>><a href="addScheduleData.php"><i class="fa fa-plus-circle"></i> Add Schedues</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewHighlights' || $pageType=='addHighlight' || $pageType=='sidebarhighlights') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-flag"></i> <span>Highlights</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewHighlights') { echo 'class="active"'; } ?>><a href="viewHighlightsData.php"><i class="fa fa-search"></i> View Highlights</a></li>
                <li <?php if($pageType=='addHighlight') { echo 'class="active"'; } ?>><a href="addHighlightData.php"><i class="fa fa-plus-circle"></i> Add Highlights</a></li>
                <li <?php if(strpos($pageType, 'sidebarhighlights') !== false) { echo 'class="active"'; }?>><a href="sidebarSettings.php?type=highlights"><i class="fa fa-th-large"></i> Sidebar widget</a></li>
               </ul>
            </li>
            <li class="treeview <?php if(strpos($pageType, 'Lib') !== false)  { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-book"></i> <span>Library</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewLibArticles') { echo 'class="active"'; } ?>><a href="viewLibArticlesData.php"><i class="fa fa-search"></i> View Articles in Library</a></li>
                <li <?php if($pageType=='addLibArticles') { echo 'class="active"'; } ?>><a href="addLibArticlesData.php"><i class="fa fa-plus-circle"></i> Add Article in Library</a></li>
                <li <?php if($pageType=='viewLibTypeData') { echo 'class="active"'; } ?>><a href="viewLibTypeData.php"><i class="fa fa-folder-open"></i> Add New Library Type</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewUsers' || $pageType=='addUser' || $pageType=='blockUsers') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-group"></i> <span>Users</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewUsers') { echo 'class="active"'; } ?>><a href="viewUsersData.php"><i class="fa fa-search"></i> View Users</a></li>
                <li <?php if($pageType=='viewUsers') { echo 'class="active"'; } ?>><a href="viewUserActivity.php"><i class="fa fa-search"></i> View Users Activity</a></li>
                <li <?php if($pageType=='addUser') { echo 'class="active"'; } ?>><a href="addUserData.php"><i class="fa fa-plus-circle"></i> Add Users</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewAnnouncements' || $pageType=='addAnnouncement') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-bullhorn"></i> <span>Announcements</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewAnnouncements') { echo 'class="active"'; } ?>><a href="viewAnnouncementsData.php"><i class="fa fa-circle-o"></i> Announcement List</a></li>
                <li <?php if($pageType=='addAnnouncement') { echo 'class="active"'; } ?>><a href="addAnnouncementData.php"><i class="fa fa-plus-circle"></i> Add Announcement</a></li>
                </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewClients' || $pageType=='addClient') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-street-view"></i> <span>Clients</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewClients') { echo 'class="active"'; } ?>><a href="viewClientsData.php"><i class="fa fa-search"></i> View Clients</a></li>
                <li <?php if($pageType=='addClient') { echo 'class="active"'; } ?>><a href="addClientdata.php"><i class="fa fa-plus-circle"></i> Add Clients</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='viewPackage' || $pageType=='viewTax' || $pageType=='viewPayment') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-money"></i> <span>Payment Gateway</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='viewPackage') { echo 'class="active"'; } ?>><a href="viewPackageData.php"><i class="fa fa-circle-o"></i> Package Master</a></li>
                <li <?php if($pageType=='viewTax') { echo 'class="active"'; } ?>><a href="viewTaxData.php"><i class="fa fa-circle-o"></i> Tax Master</a></li>
                <li <?php if($pageType=='viewPayment') { echo 'class="active"'; } ?>><a href="viewPaymentData.php"><i class="fa fa-circle-o"></i> Payment History</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='mediaImages') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-photo"></i> <span>Media</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='mediaImages') { echo 'class="active"'; } ?>><a href="mediaLibrary.php"><i class="fa fa-circle-o"></i> Images</a></li>
               </ul>
            </li>
            <li class="treeview <?php if($pageType=='mediaImages') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-photo"></i> <span>Banner Master</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='mediaImages') { echo 'class="active"'; } ?>><a href="banner.php"><i class="fa fa-circle-o"></i> Images</a></li>
               </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
    authDomain: "vilgst.firebaseapp.com",
    projectId: "vilgst",
    storageBucket: "vilgst.appspot.com",
    messagingSenderId: "493343969816",
    appId: "1:493343969816:web:2ea8047fba70f4980d696d",
    measurementId: "G-DQNYHJLPB3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>