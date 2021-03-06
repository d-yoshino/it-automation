<?php
//   Copyright 2019 NEC Corporation
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//       http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//   limitations under the License.
//
//////////////////////////////////////////////////////////////////////
//
//  【処理概要】
//    ・WebDBCore機能を用いたWebページの中核設定を行う。
//
//////////////////////////////////////////////////////////////////////

$tmpFx = function (&$aryVariant=array(),&$arySetting=array()){
	global $g;

	$arrayWebSetting = array();
    $arrayWebSetting['page_info'] = $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090001");

    // 項番
    $table = new TableControlAgent('D_ROLE_ACCOUNT_LINK_LIST','LINK_ID', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090101"), 'D_ROLE_ACCOUNT_LINK_LIST_JNL');
    $table->setDBMainTableLabel($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090002"));
    $table->getFormatter("excel")->setGeneValue("sheetNameForEditByFile",$g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090003"));
    
    $table->setGeneObject('AutoSearchStart',true);  //('',true,false)
    
    $table->setGeneObject("webSetting", $arrayWebSetting);

    $table->setDBMainTableHiddenID('A_ROLE_ACCOUNT_LINK_LIST');
    $table->setDBJournalTableHiddenID('A_ROLE_ACCOUNT_LINK_LIST_JNL');

    $tmpAryObjColumn = $table->getColumns();
    $c = $tmpAryObjColumn['LINK_ID'];
    $c->setSequenceID('SEQ_A_ROLE_ACCOUNT_LINK_LIST');

    $c = $tmpAryObjColumn['DISUSE_FLAG'];
    $c->setDefaultValue("filter_table",array(""));

    $table->addUniqueColumnSet(array('ROLE_ID','USER_ID'));

    // ----カラムグループ（ロール）
    $cg = new ColumnGroup($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090701"));

	    // ロールID
	    $c = new IDColumn('ROLE_ID_CLONE', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090201"), "D_ROLE_LIST", 'ROLE_ID', "ROLE_ID", '', array('OrderByThirdColumn'=>'ROLE_ID'));
	    $c->setDescription($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090202"));

    	$c->getOutputType("update_table")->setVisible(false);
    	$c->getOutputType("register_table")->setVisible(false);
    	$c->getOutputType("excel")->setVisible(false);
    	$c->getOutputType("csv")->setVisible(false);
	    $c->setMasterDisplayColumnType(0);
	    //----復活時に二重チェックになるので付加
	    $c->setDeleteOffBeforeCheck(false);
	    //復活時に二重チェックになるので付加----
	    $objOT = new TraceOutputType(new ReqTabHFmt(), new TextTabBFmt());
	    $aryTraceQuery = array(
	        array(
	            'TRACE_TARGET_TABLE'=>'A_ROLE_LIST_JNL',
	            'TTT_SEARCH_KEY_COLUMN_ID'=>'ROLE_ID',
	            'TTT_GET_TARGET_COLUMN_ID'=>'ROLE_ID',
	            'TTT_JOURNAL_SEQ_NO'=>'JOURNAL_SEQ_NO',
	            'TTT_TIMESTAMP_COLUMN_ID'=>'LAST_UPDATE_TIMESTAMP',
	            'TTT_DISUSE_FLAG_COLUMN_ID'=>'DISUSE_FLAG'
	        )
	    );
	    $objOT->setTraceQuery($aryTraceQuery);
	    $objOT->setFirstSearchValueOwnerColumnID('ROLE_ID');
	    $c->setOutputType('print_journal_table',$objOT);
        $cg->addColumn($c);

	    // ロール名称
	    $c = new TextColumn('ROLE_NAME', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090801"));
	    $c->setDescription($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090802"));
	    $c->getOutputType("update_table")->setVisible(false);
	    $c->getOutputType("register_table")->setVisible(false);
	    $c->getOutputType("excel")->setVisible(false);
	    $c->getOutputType("csv")->setVisible(false);
	    $objOT = new TraceOutputType(new ReqTabHFmt(), new TextTabBFmt());
	    $aryTraceQuery = array(
	        array(
	            'TRACE_TARGET_TABLE'=>'A_ROLE_LIST_JNL',
	            'TTT_SEARCH_KEY_COLUMN_ID'=>'ROLE_ID',
	            'TTT_GET_TARGET_COLUMN_ID'=>'ROLE_NAME',
	            'TTT_JOURNAL_SEQ_NO'=>'JOURNAL_SEQ_NO',
	            'TTT_TIMESTAMP_COLUMN_ID'=>'LAST_UPDATE_TIMESTAMP',
	            'TTT_DISUSE_FLAG_COLUMN_ID'=>'DISUSE_FLAG'
	        )
	    );
	    $objOT->setTraceQuery($aryTraceQuery);
	    $objOT->setFirstSearchValueOwnerColumnID('ROLE_ID');
	    $c->setOutputType('print_journal_table',$objOT);
        $cg->addColumn($c);

    $table->addColumn($cg);
    
    // ロールID:名称
    $c = new IDColumn('ROLE_ID', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090901"), "D_ROLE_LIST", 'ROLE_ID', "ROLE_PULLDOWN", '', array('OrderByThirdColumn'=>'ROLE_ID'));
    $c->setHiddenMainTableColumn(true);
    $c->setRequired(true);    
    $c->setDescription($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090902"));
    $c->getOutputType("delete_table")->setVisible(false);
    $c->getOutputType("filter_table")->setVisible(false);
    $c->getOutputType("print_table")->setVisible(false);
    $c->getOutputType("print_journal_table")->setVisible(false);
    $table->addColumn($c);

    // ユーザ
    $cg = new ColumnGroup($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090301"));

    // ID
    //----チケット953
    $c = new IDColumn('USER_ID_CLONE', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090401"), "D_ACCOUNT_LIST", 'USER_ID', 'USER_ID', '', array('OrderByThirdColumn'=>'USER_ID'));
    $c->addClass("number");
    $c->setDescription($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090402"));
    $c->setHiddenMainTableColumn(false);
    $c->setAllowSendFromFile(false);
    $c->getOutputType("update_table")->setVisible(false);
    $c->getOutputType("register_table")->setVisible(false);
    $c->getOutputType("excel")->setVisible(false);
    $c->getOutputType("csv")->setVisible(false);
    $c->setMasterDisplayColumnType(0);
    //----復活時に二重チェックになるので付加
    $c->setDeleteOffBeforeCheck(false);
    //復活時に二重チェックになるので付加----
    $objOT = new TraceOutputType(new ReqTabHFmt(), new TextTabBFmt());
    $aryTraceQuery = array(
        array(
            'TRACE_TARGET_TABLE'=>'A_ACCOUNT_LIST_JNL',
            'TTT_SEARCH_KEY_COLUMN_ID'=>'USER_ID',
            'TTT_GET_TARGET_COLUMN_ID'=>'USER_ID',
            'TTT_JOURNAL_SEQ_NO'=>'JOURNAL_SEQ_NO',
            'TTT_TIMESTAMP_COLUMN_ID'=>'LAST_UPDATE_TIMESTAMP',
            'TTT_DISUSE_FLAG_COLUMN_ID'=>'DISUSE_FLAG'
        )
    );
    $objOT->setTraceQuery($aryTraceQuery);
    $objOT->setFirstSearchValueOwnerColumnID('USER_ID');
    $c->setOutputType('print_journal_table',$objOT);
    $cg->addColumn($c);

    // ログインID
    $c = new TextColumn('USERNAME', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090501"));
    $c->setHiddenMainTableColumn(false);
    $c->setAllowSendFromFile(false);
    $c->setDescription($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090502"));
    $c->getOutputType("update_table")->setVisible(false);
    $c->getOutputType("register_table")->setVisible(false);
    $c->getOutputType("excel")->setVisible(false);
    $c->getOutputType("csv")->setVisible(false);
    $c->getOutputType("print_journal_table")->setVisible(false);
    $cg->addColumn($c);
    $table->addColumn($cg);

    // ID
    $c = new IDColumn('USER_ID', $g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090601"), 'D_ACCOUNT_LIST', 'USER_ID', 'USER_PULLDOWN', '', array('OrderByThirdColumn'=>'USER_ID'));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAWDCH-MNU-1090602"));
    $c->getOutputType("delete_table")->setVisible(false);
    $c->getOutputType("filter_table")->setVisible(false);
    $c->getOutputType("print_table")->setVisible(false);
    $c->getOutputType("print_journal_table")->setVisible(false);
    $c->setHiddenMainTableColumn(true);
    $c->setRequired(true);    
    $table->addColumn($c);

    $table->fixColumn();

	return $table;
};
loadTableFunctionAdd($tmpFx,__FILE__);
unset($tmpFx);
?>
