<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Welcome to ADMIN PANEL</li>
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

            <li class="treeview <?php if($pageType=='addSearchCategory') { echo 'active'; }?>">
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Search Category</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($pageType=='addSearchCategory') { echo 'class="active"'; } ?>><a href="addSearchCategory.php"><i class="fa fa-search"></i>Add Search Category</a></li>
                <li <?php if($pageType=='addArticle') { echo 'class="active"'; } ?>><a href="addArticleData.php"><i class="fa fa-plus-circle"></i> Add Articles</a></li>
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
                <i class="fa fa-server"></i> <span>Schedues</span> <i class="fa fa-angle-right pull-right"></i>
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
