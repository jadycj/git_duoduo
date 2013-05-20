<?php exit;?>{"ad":{"id":"int(11) NOT NULL auto_increment","img":"varchar(255) default NULL","link":"varchar(255) default NULL","title":"varchar(100) default NULL","height":"varchar(5) NOT NULL","width":"varchar(5) NOT NULL","content":"text default NULL","adtype":"varchar(255) default NULL","addtime":"int(11) NOT NULL default \"0\"","sys":"tinyint(1) NOT NULL default \"0\"","edate":"int(10) NOT NULL default \"0\"","type":"tinyint(1) NOT NULL default \"1\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"adminlog":{"id":"int(11) NOT NULL auto_increment","admin_name":"varchar(50) NOT NULL","ip":"varchar(15) NOT NULL","mod":"varchar(50) NOT NULL","do":"varchar(20) NOT NULL","addtime":"int(10) NOT NULL","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `admin_name` (`admin_name`),KEY `mod` (`mod`),KEY `addtime` (`addtime`)"},"api":{"id":"int(5) NOT NULL auto_increment","key":"varchar(100) NOT NULL","secret":"varchar(100) NOT NULL","title":"varchar(50) NOT NULL","code":"varchar(10) NOT NULL","open":"int(1) NOT NULL default \"0\"","sort":"int(11) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","sys":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"apilogin":{"id":"int(11) NOT NULL auto_increment","uid":"int(11) NOT NULL","webid":"varchar(50) NOT NULL","webname":"varchar(50) NOT NULL","web":"varchar(20) NOT NULL","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `uid` (`uid`),KEY `webid` (`webid`),KEY `web` (`web`)"},"appkey":{"id":"int(11) NOT NULL auto_increment","key":"int(20) NOT NULL","secret":"varchar(50) NOT NULL","sort":"int(5) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"article":{"id":"int(11) NOT NULL auto_increment","cid":"int(11)","title":"varchar(200) default NULL","img":"varchar(200) default NULL","source":"varchar(200) default NULL","content":"text default NULL","hits":"int(11) default \"0\"","sort":"int(11) default \"0\"","keyword":"varchar(255) default NULL","desc":"varchar(255) default NULL","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"baobei":{"id":"int(11) NOT NULL auto_increment","uid":"int(11) NOT NULL","tao_id":"bigint(12) NOT NULL","trade_id":"int(11) NOT NULL default \"0\"","img":"varchar(255) default NULL","title":"varchar(100) default NULL","nick":"varchar(50) default NULL","price":"double(10,2) NOT NULL default \"0.00\"","commission":"double(10,2) NOT NULL default \"0.00\"","jifen":"int(11) NOT NULL default \"0\"","jifenbao":"double(10,2) NOT NULL default \"0.00\"","cid":"int(2) NOT NULL default \"1\"","click_url":"text default NULL","keywords":"varchar(100) default NULL","content":"text NOT NULL","hart":"int(10) NOT NULL default \"0\"","hits":"int(11) NOT NULL default \"0\"","addtime":"int(10) NOT NULL","sort":"int(11) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `tao_id` (`tao_id`),KEY `trade_id` (`trade_id`),KEY `title` (`title`),KEY `cid` (`cid`),KEY `sort` (`sort`)"},"baobei_blacklist":{"id":"int(11) NOT NULL auto_increment","tao_id":"bigint(12) NOT NULL","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `tao_id` (`tao_id`)"},"baobei_comment":{"id":"int(10) NOT NULL auto_increment","baobei_id":"int(11) NOT NULL","comment":"varchar(140) NOT NULL","addtime":"int(10) NOT NULL default \"0\"","uid":"int(11) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `baobei_id` (`baobei_id`)"},"baobei_hart":{"id":"int(10) NOT NULL auto_increment","baobei_id":"int(11) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","uid":"int(11) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `baobei_id` (`baobei_id`)"},"city":{"id":"int(11) NOT NULL auto_increment","title":"varchar(32) NOT NULL","sort":"int(5) NOT NULL default \"0\"","pinyin":"varchar(32) NOT NULL","first_word":"varchar(1) NOT NULL","hide":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"duihuan":{"id":"int(11) NOT NULL auto_increment","uid":"int(11) NOT NULL default \"0\"","spend":"double(6,2) NOT NULL default \"0.00\"","ip":"varchar(20) default NULL","huan_goods_id":"int(11) NOT NULL default \"0\"","realname":"varchar(30) NOT NULL","address":"varchar(100) NOT NULL","email":"varchar(50) default NULL","mobile":"bigint(15) NOT NULL default \"0\"","qq":"varchar(20) default NULL","content":"text default NULL","addtime":"int(10) NOT NULL default \"0\"","shoptime":"int(10) NOT NULL default \"0\"","status":"int(1) NOT NULL default \"0\"","mode":"tinyint(1) NOT NULL default \"1\"","why":"varchar(255) default NULL","num":"int(11) NOT NULL default \"1\"","alipay":"varchar(50) default NULL","duoduo_table_index":"PRIMARY KEY  (`id`)"},"duoduo2010":{"id":"int(11) NOT NULL auto_increment","adminname":"varchar(30) default NULL","adminpass":"varchar(50) default NULL","lastlogintime":"int(10) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","lastloginip":"varchar(15) default NULL","loginnum":"int(11) default \"0\"","logintime":"int(10) NOT NULL default \"0\"","loginip":"varchar(15) default NULL","role":"int(5) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `adminname` (`adminname`)"},"file":{"id":"int(11) NOT NULL auto_increment","path":"varchar(255) default NULL","size":"int(11) NOT NULL default \"0\"","time":"int(10) NOT NULL default \"0\"","md5":"varchar(50) default NULL","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `path` (`path`)"},"goods":{"id":"int(11) NOT NULL auto_increment","cid":"int(11) NOT NULL default \"1\"","iid":"bigint(11) NOT NULL","pic_url":"varchar(100) NOT NULL","price":"double(10,2) NOT NULL default \"0.00\"","title":"varchar(100) NOT NULL","click_url":"text default NULL","commission":"double(10,2) NOT NULL default \"0.00\"","nick":"varchar(20) NOT NULL","uid":"int(11) NOT NULL default \"0\"","sort":"int(11) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","day":"int(10) NOT NULL default \"1\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"huan_goods":{"id":"int(11) NOT NULL auto_increment","cid":"int(11) NOT NULL default \"0\"","img":"varchar(255) default NULL","jifen":"int(10) NOT NULL default \"0\"","jifenbao":"double(10,2) NOT NULL default \"0.00\"","title":"varchar(100) default NULL","hide":"tinyint(1) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","sort":"int(10) default \"0\"","content":"text default NULL","num":"int(11) NOT NULL default \"1\"","array":"text default NULL","auto":"tinyint(1) NOT NULL default \"0\"","sdate":"int(10) NOT NULL default \"0\"","edate":"bigint(11) NOT NULL default \"0\"","limit":"int(11) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"huodong":{"id":"int(10) NOT NULL auto_increment","mall_id":"int(11) NOT NULL default \"0\"","title":"varchar(50) NOT NULL","img":"varchar(255) NOT NULL","sdate":"bigint(11) NOT NULL default \"0\"","edate":"bigint(11) NOT NULL default \"0\"","url":"varchar(255) NOT NULL","desc":"varchar(255) NOT NULL","content":"text NOT NULL","sort":"int(10) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","relate_id":"int(11) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `sdate` (`sdate`)"},"income":{"id":"int(11) NOT NULL auto_increment","uid":"int(11) NOT NULL","money":"double(10,2) NOT NULL default \"0.00\"","jifen":"int(11) NOT NULL default \"0\"","date":"int(6) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `uid` (`uid`),KEY `date` (`date`)"},"link":{"id":"int(11) NOT NULL auto_increment","url":"varchar(255) default NULL","title":"varchar(255) default NULL","addtime":"int(10) NOT NULL default \"0\"","type":"int(1) NOT NULL default \"0\"","img":"varchar(255) default NULL","sort":"int(11) default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"mall":{"id":"int(11) NOT NULL auto_increment","title":"varchar(30) default NULL","pinyin":"varchar(100) default NULL","merchant":"varchar(20) default NULL","url":"varchar(255) default NULL","img":"varchar(255) default NULL","cid":"int(11) NOT NULL default \"0\"","fan":"varchar(15) default NULL","des":"varchar(255) default \"\u6682\u65e0\"","content":"text default NULL","addtime":"int(10) NOT NULL default \"0\"","sort":"int(11) NOT NULL default \"0\"","yiqifaurl":"varchar(255) default NULL","lm":"tinyint(2) NOT NULL default \"0\"","edate":"bigint(11) NOT NULL default \"0\"","renzheng":"tinyint(1) NOT NULL default \"1\"","api_url":"varchar(255) default NULL","api_rule":"varchar(50) default NULL","api_city":"varchar(255) default NULL","duomaiid":"int(11) default \"0\"","yiqifaid":"int(11) default \"0\"","chanetid":"int(11) default \"0\"","chanet_draftid":"int(11) default \"0\"","chaneturl":"varchar(255) default NULL","weiyiid":"varchar(20) default NULL","wujiumiaoid":"int(10) NOT NULL default \"0\"","wujiumiaourl":"varchar(255) default NULL","type":"tinyint(1) NOT NULL default \"1\"","merchantId":"int(11) default \"0\"","score":"double(3,2) NOT NULL default \"0.00\"","pjnum":"int(11) NOT NULL default \"0\"","fuwu":"varchar(255) default \"\u8d27\u5230\u4ed8\u6b3e\uff1a\u6709 \u6b63\u89c4\u53d1\u7968\uff1a\u6709 \u8fd0\u8d39\u653f\u7b56\uff1a\u8d2d\u6ee1XX\u514d\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `merchant` (`merchant`),KEY `cid` (`cid`),KEY `sort` (`sort`),KEY `edate` (`edate`),KEY `duomaiid` (`duomaiid`),KEY `yiqifaid` (`yiqifaid`),KEY `chanetid` (`chanetid`)"},"mall_comment":{"id":"int(11) NOT NULL auto_increment","mall_id":"int(11) NOT NULL","uid":"int(11) NOT NULL","fen":"tinyint(1) NOT NULL default \"0\"","content":"text default NULL","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `mall_id` (`mall_id`)"},"mall_order":{"id":"int(11) NOT NULL auto_increment","order_time":"varchar(20) default NULL","mall_name":"varchar(30) default NULL","mall_id":"int(11) NOT NULL default \"0\"","adid":"varchar(15) NOT NULL","uid":"int(11) default \"0\"","order_code":"varchar(50) default NULL","item_count":"int(5)","item_price":"double(10,2) NOT NULL default \"0.00\"","sales":"double(15,2) NOT NULL default \"0.00\"","commission":"double(10,2) NOT NULL default \"0.00\"","fxje":"double(10,2) NOT NULL default \"0.00\"","jifen":"int(10) NOT NULL default \"0\"","tgyj":"double(8,2) NOT NULL default \"0.00\"","addtime":"int(10) NOT NULL default \"0\"","status":"tinyint(1) NOT NULL default \"0\"","qrsj":"int(10) NOT NULL default \"0\"","product_code":"varchar(50) default NULL","lm":"tinyint(1) NOT NULL default \"0\"","unique_id":"varchar(100) default NULL","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `mall_id` (`mall_id`),KEY `adid` (`adid`),KEY `uid` (`uid`),KEY `status` (`status`),UNIQUE KEY `unique_id` (`unique_id`)"},"menu":{"id":"int(11) NOT NULL auto_increment","parent_id":"int(11) NOT NULL default \"0\"","node":"varchar(20) NOT NULL","mod":"varchar(50) NOT NULL","act":"varchar(15) NOT NULL","listorder":"int(11) NOT NULL default \"0\"","sort":"int(5) NOT NULL default \"0\"","title":"varchar(20) NOT NULL","hide":"tinyint(1) NOT NULL default \"0\"","sys":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `mod` (`mod`),KEY `act` (`act`),KEY `sort` (`sort`)"},"menu_access":{"id":"int(11) NOT NULL auto_increment","role_id":"int(11) NOT NULL","menu_id":"int(11) NOT NULL","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `role_id` (`role_id`),KEY `menu_id` (`menu_id`)"},"mingxi":{"id":"int(11) NOT NULL auto_increment","uid":"int(11) NOT NULL default \"0\"","shijian":"tinyint(4) NOT NULL default \"0\"","money":"double(10,2) default \"0.00\"","jifen":"int(5) NOT NULL default \"0\"","addtime":"datetime default NULL","source":"varchar(50) default NULL","relate_id":"int(11) NOT NULL default \"0\"","leave_money":"double(10,2) default \"0.00\"","jifenbao":"double(10,2) NOT NULL default \"0.00\"","leave_jifenbao":"double(10,2) NOT NULL default \"0.00\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `uid` (`uid`),KEY `shijian` (`shijian`)"},"msg":{"id":"int(11) NOT NULL auto_increment","title":"varchar(100) default NULL","content":"varchar(255) default NULL","addtime":"datetime default NULL","see":"int(11) default \"0\"","uid":"int(11) NOT NULL default \"0\"","senduser":"int(11) NOT NULL default \"0\"","sid":"int(11) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `uid` (`uid`)"},"msgset":{"id":"int(11) NOT NULL auto_increment","web":"text default NULL","email":"text default NULL","sms":"text default NULL","title":"varchar(255) default NULL","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"nav":{"id":"int(5) NOT NULL auto_increment","title":"varchar(20) NOT NULL","url":"text default NULL","tip":"tinyint(1) NOT NULL default \"0\"","sort":"int(5) NOT NULL default \"0\"","hide":"tinyint(1) NOT NULL default \"0\"","type":"tinyint(4) NOT NULL default \"0\"","auto":"tinyint(1) NOT NULL default \"0\"","target":"tinyint(1) NOT NULL default \"0\"","custom":"varchar(255) default NULL","mod":"varchar(20) default NULL","act":"varchar(20) default NULL","tag":"varchar(10) default NULL","addtime":"int(10) NOT NULL default \"0\"","pid":"int(11) NOT NULL default \"0\"","alt":"varchar(30) default NULL","sys":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"noword":{"id":"int(11) NOT NULL auto_increment","title":"varchar(255) NOT NULL","replace":"varchar(50) default NULL","title_arr":"varchar(255) default NULL","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `title` (`title`)"},"paipai_order":{"id":"int(11) NOT NULL auto_increment","dealId":"int(11) NOT NULL default \"0\"","discount":"double(3,2) NOT NULL default \"0.00\"","careAmount":"double(10,2) NOT NULL default \"0.00\"","commission":"double(8,2) NOT NULL default \"0.00\"","realCost":"double(8,2) NOT NULL default \"0.00\"","bargainState":"tinyint(1) NOT NULL default \"0\"","chargeTime":"int(11) NOT NULL default \"0\"","commNum":"int(11) NOT NULL","commId":"varchar(50) default NULL","commName":"varchar(100) default NULL","classId":"int(11) NOT NULL default \"0\"","className":"varchar(20) default NULL","shopId":"int(11) NOT NULL default \"0\"","shopName":"varchar(100) NOT NULL","outInfo":"varchar(50) default NULL","uid":"int(11) NOT NULL default \"0\"","fxje":"double(8,2) NOT NULL default \"0.00\"","jifen":"int(11) NOT NULL default \"0\"","tgyj":"double(5,2) NOT NULL default \"0.00\"","addtime":"int(11) NOT NULL default \"0\"","checked":"tinyint(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `dealId` (`dealId`),KEY `uid` (`uid`),KEY `addtime` (`addtime`),KEY `checked` (`checked`)"},"role":{"id":"int(6) unsigned NOT NULL auto_increment","title":"varchar(50) NOT NULL","status":"tinyint(1) unsigned NOT NULL","sys":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"seo":{"id":"int(11) NOT NULL auto_increment","mod":"varchar(10) NOT NULL","act":"varchar(10) default NULL","title":"varchar(255) default NULL","keyword":"varchar(255) default NULL","desc":"varchar(255) default NULL","label":"text default NULL","sys":"tinyint(1) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"service":{"id":"int(5) NOT NULL auto_increment","title":"varchar(50) NOT NULL","code":"varchar(50) NOT NULL","type":"tinyint(1) NOT NULL","sort":"int(10) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"shop":{"id":"int(11) NOT NULL auto_increment","nick":"varchar(50) default NULL","uid":"int(11) NOT NULL default \"0\"","cid":"int(11) NOT NULL default \"0\"","level":"int(10)","score":"int(11)","auction_count":"int(11) NOT NULL default \"0\"","sid":"int(11) NOT NULL default \"0\"","title":"varchar(100) default NULL","pic_path":"varchar(255) default NULL","created":"datetime NOT NULL","shop_click_url":"text default NULL","type":"char(1) default \"C\"","addtime":"int(11) NOT NULL default \"0\"","hits":"int(11) default \"0\"","sort":"int(11) NOT NULL default \"0\"","item_score":"double(2,1) NOT NULL default \"0.0\"","service_score":"double(2,1) NOT NULL default \"0.0\"","delivery_score":"double(2,1) NOT NULL default \"0.0\"","fanxianlv":"double(4,2) NOT NULL default \"0.00\"","top":"tinyint(1) NOT NULL default \"0\"","taoke":"tinyint(1) NOT NULL default \"1\"","total_auction":"int(11) NOT NULL default \"0\"","index_top":"tinyint(1) NOT NULL default \"0\"","tao_top":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `nick` (`nick`),KEY `cid` (`cid`),UNIQUE KEY `sid` (`sid`),KEY `sort` (`sort`),KEY `index_top` (`index_top`)"},"slides":{"id":"int(11) NOT NULL auto_increment","img":"varchar(255) default NULL","url":"text default NULL","title":"varchar(100) default NULL","hide":"int(11) default \"0\"","addtime":"int(11) NOT NULL default \"0\"","sort":"int(11) NOT NULL default \"10\"","cid":"int(5) NOT NULL default \"1\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"tgyj":{"id":"int(11) NOT NULL auto_increment","tjrid":"int(11) NOT NULL","uid":"int(11) NOT NULL","money":"double(10,2) NOT NULL default \"0.00\"","hytx":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `tjrid` (`tjrid`),UNIQUE KEY `uid` (`uid`)"},"tixian":{"id":"int(11) NOT NULL auto_increment","uid":"int(11) NOT NULL","money":"double(10,2) NOT NULL default \"0.00\"","money2":"double(10,2) NOT NULL default \"0.00\"","addtime":"int(10) NOT NULL","ip":"varchar(20) default NULL","status":"tinyint(1) default \"0\"","realname":"varchar(30) default NULL","mobile":"bigint(20) NOT NULL default \"0\"","why":"varchar(255) default NULL","remark":"text default NULL","code":"varchar(50) default NULL","type":"tinyint(1) NOT NULL default \"1\"","api_return":"varchar(100) default NULL","tool":"int(1) NOT NULL default \"1\"","wait":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `uid` (`uid`)"},"tradelist":{"id":"int(11) NOT NULL auto_increment","pay_time":"datetime default NULL","item_title":"varchar(255) default NULL","shop_title":"varchar(255) default NULL","num_iid":"bigint(15) NOT NULL default \"0\"","seller_nick":"varchar(50) default NULL","pay_price":"double(10,2) NOT NULL default \"0.00\"","commission_rate":"double(5,2) NOT NULL default \"0.00\"","commission":"double(10,2) NOT NULL default \"0.00\"","item_num":"int(11) NOT NULL default \"0\"","trade_id":"bigint(20) NOT NULL default \"0\"","outer_code":"varchar(12) NOT NULL","uid":"int(11) NOT NULL default \"0\"","app_key":"int(11) NOT NULL default \"0\"","category_id":"int(11) NOT NULL default \"0\"","category_name":"varchar(20) default NULL","qrsj":"int(10) NOT NULL default \"0\"","fxje":"double(10,2) NOT NULL default \"0.00\"","jifen":"int(11) NOT NULL default \"0\"","tgyj":"double(5,2) NOT NULL default \"0.00\"","checked":"tinyint(1) NOT NULL default \"0\"","ddjt":"varchar(255) default NULL","real_pay_fee":"double(10,2) NOT NULL default \"0.00\"","jifenbao":"double(10,2) NOT NULL default \"0.00\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `pay_time` (`pay_time`),UNIQUE KEY `trade_id` (`trade_id`),KEY `uid` (`uid`),KEY `checked` (`checked`)"},"tuan_goods":{"id":"int(11) NOT NULL auto_increment","url":"varchar(255) default NULL","mall_id":"int(11) NOT NULL default \"0\"","city":"varchar(50) default NULL","cid":"int(10) NOT NULL default \"0\"","title":"varchar(255) default NULL","img":"varchar(255) default NULL","sdatetime":"bigint(11) NOT NULL default \"0\"","edatetime":"bigint(11) NOT NULL default \"0\"","value":"double(10,2) NOT NULL default \"0.00\"","price":"double(10,2) NOT NULL default \"0.00\"","rebate":"double(10,1) NOT NULL default \"0.0\"","bought":"int(10) NOT NULL default \"0\"","addtime":"int(10) NOT NULL default \"0\"","sort":"int(10) NOT NULL default \"0\"","top":"tinyint(1) NOT NULL default \"0\"","salt":"bigint(13) NOT NULL default \"0\"","content":"text default NULL","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `city` (`city`),KEY `title` (`title`),KEY `sort` (`sort`),UNIQUE KEY `salt` (`salt`)"},"tuan_type":{"id":"int(2) NOT NULL auto_increment","title":"varchar(200) NOT NULL","sort":"int(5) NOT NULL default \"0\"","content":"text default NULL","addtime":"int(11) NOT NULL","sys":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"type":{"id":"int(11) NOT NULL auto_increment","pid":"int(11) default \"0\"","title":"varchar(50) default NULL","sort":"int(11) default \"0\"","tag":"varchar(20) NOT NULL","addtime":"int(10) NOT NULL default \"0\"","sys":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`)"},"user":{"id":"int(11) NOT NULL auto_increment","ddusername":"varchar(50) default \"a\"","ddpassword":"varchar(50) default NULL","realname":"varchar(50) default NULL","regtime":"datetime default NULL","regip":"varchar(15) default NULL","loginnum":"int(11) NOT NULL default \"0\"","lastlogintime":"datetime default NULL","lasttixian":"int(10) NOT NULL default \"0\"","alipay":"varchar(50) default NULL","email":"varchar(50) default NULL","money":"double(10,2) default \"0.00\"","jifen":"int(11) NOT NULL default \"0\"","txstatus":"tinyint(1) NOT NULL default \"0\"","dhstate":"tinyint(1) NOT NULL default \"0\"","level":"int(11) NOT NULL default \"0\"","tjr":"int(11) NOT NULL default \"0\"","tjr_over":"int(11) NOT NULL default \"0\"","mobile":"bigint(12) NOT NULL default \"0\"","mobile_test":"tinyint(1) NOT NULL default \"0\"","qq":"varchar(50) default NULL","pass_question":"varchar(250) default NULL","pass_answer":"varchar(250) default NULL","yitixian":"double(10,2) NOT NULL default \"0.00\"","fxb":"tinyint(1) NOT NULL default \"0\"","hart":"int(11) NOT NULL default \"0\"","jihuo":"tinyint(1) NOT NULL default \"1\"","ucid":"int(11) NOT NULL default \"0\"","hytx":"tinyint(1) NOT NULL default \"0\"","signtime":"int(10) NOT NULL default \"0\"","tenpay":"varchar(50) default NULL","bank_name":"varchar(20) default NULL","bank_code":"varchar(20) default \"0\"","jifenbao":"double(10,2) NOT NULL default \"0.00\"","tbtxstatus":"tinyint(1) NOT NULL default \"0\"","tbyitixian":"double(10,2) NOT NULL default \"0.00\"","txtool":"tinyint(1) NOT NULL default \"1\"","duoduo_table_index":"PRIMARY KEY  (`id`),KEY `alipay` (`alipay`),UNIQUE KEY `email` (`email`),KEY `tjr` (`tjr`),KEY `tenpay` (`tenpay`),KEY `bank_code` (`bank_code`)"},"webset":{"id":"int(11) NOT NULL auto_increment","var":"varchar(50) NOT NULL","val":"text default NULL","type":"tinyint(1) NOT NULL default \"0\"","duoduo_table_index":"PRIMARY KEY  (`id`),UNIQUE KEY `var` (`var`)"}}