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
//    ・紐付メニューカラム情報
//
//////////////////////////////////////////////////////////////////////

$tmpFx = function (&$aryVariant=array(),&$arySetting=array()){
    global $g;

    $arrayWebSetting = array();
    $arrayWebSetting['page_info'] = $g['objMTS']->getSomeMessage("ITABASEH-MNU-213000");
/*
紐付メニューカラム情報
*/
    $tmpAry = array(
        'TT_SYS_01_JNL_SEQ_ID'=>'JOURNAL_SEQ_NO',
        'TT_SYS_02_JNL_TIME_ID'=>'JOURNAL_REG_DATETIME',
        'TT_SYS_03_JNL_CLASS_ID'=>'JOURNAL_ACTION_CLASS',
        'TT_SYS_04_NOTE_ID'=>'NOTE',
        'TT_SYS_04_DISUSE_FLAG_ID'=>'DISUSE_FLAG',
        'TT_SYS_05_LUP_TIME_ID'=>'LAST_UPDATE_TIMESTAMP',
        'TT_SYS_06_LUP_USER_ID'=>'LAST_UPDATE_USER',
        'TT_SYS_NDB_ROW_EDIT_BY_FILE_ID'=>'ROW_EDIT_BY_FILE',
        'TT_SYS_NDB_UPDATE_ID'=>'WEB_BUTTON_UPDATE',
        'TT_SYS_NDB_LUP_TIME_ID'=>'UPD_UPDATE_TIMESTAMP'
    );

    $table = new TableControlAgent('B_CMDB_MENU_COLUMN','COLUMN_LIST_ID',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213001"), 'B_CMDB_MENU_COLUMN_JNL', $tmpAry);
    $tmpAryColumn = $table->getColumns();
    $tmpAryColumn['COLUMN_LIST_ID']->setSequenceID('B_CMDB_MENU_COLUMN_RIC');
    $tmpAryColumn['JOURNAL_SEQ_NO']->setSequenceID('B_CMDB_MENU_COLUMN_JSQ');
    unset($tmpAryColumn);

    // QMファイル名プレフィックス
    $table->setDBMainTableLabel($g['objMTS']->getSomeMessage("ITABASEH-MNU-213002"));
    // エクセルのシート名
    $table->getFormatter('excel')->setGeneValue('sheetNameForEditByFile',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213003"));

    //---- 検索機能の制御
    $table->setGeneObject('AutoSearchStart',true);  //('',true,false)
    // 検索機能の制御----




    //メニュー
    $c = new IDColumn('MENU_ID',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213004"),'D_CMDB_TARGET_MENU_LIST','MENU_ID','MENU_PULLDOWN','',array('OrderByThirdColumn'=>'MENU_ID'));
    $c->setDescription('');//エクセル・ヘッダでの説明
    $c->setRequired(true);//登録/更新時には、入力必須

    $table->addColumn($c);

    //カラム
    $c = new TextColumn('COL_NAME',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213005"));
    $c->setDescription('');//エクセル・ヘッダでの説明
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    //項目名
    $c = new TextColumn('COL_TITLE',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213006"));
    $c->setDescription('');//エクセル・ヘッダでの説明
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    //カラム表示順
    $c = new NumColumn('COL_TITLE_DISP_SEQ',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213010"));
    $c->setDescription($g['objMTS']->getSomeMessage("ITABASEH-MNU-213010"));
    $c->setSubtotalFlag(false);
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    //参照テーブル
    $c = new TextColumn('REF_TABLE_NAME',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213007"));
    $c->setDescription('');//エクセル・ヘッダでの説明
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    //参照主キー
    $c = new TextColumn('REF_PKEY_NAME',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213008"));
    $c->setDescription('');//エクセル・ヘッダでの説明
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    //参照カラム
    $c = new TextColumn('REF_COL_NAME',$g['objMTS']->getSomeMessage("ITABASEH-MNU-213009"));
    $c->setDescription('');//エクセル・ヘッダでの説明
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);


//----head of setting [multi-set-unique]
    $table->addUniqueColumnSet(array('MENU_ID','COL_NAME'));
//tail of setting [multi-set-unique]----

    $table->fixColumn();

    $table->setGeneObject('webSetting', $arrayWebSetting);
    return $table;
};
loadTableFunctionAdd($tmpFx,__FILE__);
unset($tmpFx);
?>
