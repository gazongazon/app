<?php
//https://kozyon.com/crm/php/test.php?test=1&die=after&force=0&aidie=0&now=1

/*
state - block of code that generates ai reuqest mesage
intent - targeted state by user but intent could != state because of depedences and other states need to pass before making this intent
task - step plan of editing funnel


User always interact with JSON text
Editing JSON happens through Tools



JSON lists:
change_global_settings
change_broadcasting_list
change_affiliate_program
edit_funnel





Create task ID and track progress on it slug:funnel_task

Editing funnel requerements:
1. Profile data
2. Strategy id
3. Create task text (Edit strategy according to it)



To prompt:
FULL STRATEGY
TASK DESCRIPTION
FULL LIST OF FEATURES

Example of the funnel in JSON:
Current funnel in JSON
Entities that we use here
Additional entityies funections names

TURNS
- Create setting and all nodes
- Go to connections between nodes




Task steps short:
Variables
Pricing plans
Pages
quizzes
Funnels list



Is user wants to use extrnal variables for this request?

manage_entity: [ID=new]node,message,page
manage_entity: funnels
change setting



get_all_variables
get_all_pricing_plans
get_all_pages
get_all_quizzes
get_all_funnels

create_variables
get_all_pricing_plans







Task steps:
Create list of variables
    - put in list vars that we already using
    - tell the user which vars you want to add or use
Create pricing plans

Create pages
    - ask page name or use existing
Create quizzes
    - Wait untill quizzes_all_done
    - Always new: Page id, qz name, comment
Edit quiz content
    - Analyze task
    — Retrive list of elements that we will use
    — Get list of elements that we will use
    — Get list of variables
    — Add elems on pages
Add content on pages
    — Define IDS page that we going to edit
        — Edit page content
        — Set Finished flag
    — Edit next page untill done
Edit logic nodes JSON


Tools to add:
Return to previous step: define variables, create pages, create quizzes, edit quiz content



Other actions during creation:
    : Current mode Edit only (I don't have ability to do much actions, only go through steps)
    - Exit from editing current task (Asking mode)
    — Edit strategy and create a new task (start process of executing task again) if user gives some different instructions. Are you sure?

How to drop current task?
Current task set prms: dropped=1

How to add new task?
Remember strategy and edit it accordig task after approval


Always keep in mind only history during task working







Prompt:
current task
exit form editing current task



Спрашивать обязательно, перед исзменением, сравнивать с текущим состоянием JSON списка
Создать новые элементы

Example:
["funnel":"","nodes":[]]



1. Get all nodes and settings in prompt + Task
2. Request certain nodes and settings trought RAG
3. Give actions:

Global settings json:
[
"google_ads":[].
]





Как перейти из одной воронки в другую
Ссылка на другую воронку


list_of_all_funnels





One task creator
Feed soft funnel




Funnel creation:
Variables
Pricing plans
Pages
+ Each page separately
+ 
Nodes




Editing funnel:






*/
/*
    if($act=='rag'){
        $a='';
        $collectionid='collection_587362cf-eadc-484a-b986-c56ec9a88793';
        extract($arr);
        if($a=='get'){
            $dd=[];
            $id=$from=$to=$res=$force=$all='';
            $limit=1000;
            extract($arr);
            $from=($from?(is_numeric($from)?date('Y-m-d H:i:s',$from):$from):'');
            $to=($to?(is_numeric($to)?date('Y-m-d H:i:s',$to):$to):'');
            $global_label=md5('ragget_'.$all.'_'.json_encode($id));
            $time_cond=($from?'time>="'.sql('safe',$from).'"':'').($from&&$to?' AND ':'').($to?'time<="'.sql('safe',$to).'"':'');
            global ${$global_label};
            if(!${$global_label}||$force){
                if($all){
                    $sql='SELECT * FROM z_rag '.($time_cond?'WHERE '.$time_cond:'').' ORDER BY id DESC '.($limit?' LIMIT '.$limit:'');
                }
                if($id){
                    $id=(is_array($id)?$id:explode(',',$id));
                    $attr=[];
                    foreach ($id as $key=>$value) {
                        $attr[]='id='.sql('safe',$value);
                    }
                    if(count($attr)==1){
                        $limit=1;
                    }
                    $attr=implode(' OR ',$attr);
                    $sql='SELECT * FROM z_rag WHERE '.$attr.($time_cond?'AND '.$time_cond:'').($limit?' LIMIT '.$limit:'');
                }
                if($sql){
                    $res=sql_get_data($sql);
                }
                if($res&&is_array($res)){
                    foreach ($res as $key=>$value) {
                        if(isset($value['params'])){
                            $res[$key]['params']=json_decode($res[$key]['params'],1);
                        }
                    }
                }
                if(!$res){
                    $res=$dd;
                }
                ${$global_label}=$res;
            } else {
                $res=${$global_label};
            }
            return $res;
        }
        if($a=='create'){
            $params=[];
            extract($arr);
            $params=($params?(is_array($params)?json_encode($params,JSON_UNESCAPED_UNICODE):$params):'');
            $rowid=sql_create_row('z_rag','params,time',$params,date('Y-m-d H:i:s'));
            return $rowid;
        }
        if($a=='remove'){
            $id='';
            extract($arr);
            sql_delete_data_for_js('z_rag','id',sql('safe',$id));
        }
        if($a=='collection_create'){
            $name='octo_funnel_rag';
            $field_definitions=[
                [
                    'key'=>'category',
                    'required'=>true,
                    'inject_into_chunk'=>true,
                    'unique'=>false
                ],
                [
                    'key'=>'dependency',
                    'required'=>false,
                    'inject_into_chunk'=>true,
                    'unique'=>false
                ],
                [
                    'key'=>'source_type',  // New example
                    'required'=>true,
                    'inject_into_chunk'=>true,
                    'unique'=>false
                ],
                [
                    'key'=>'priority_level',  // New example
                    'required'=>false,
                    'inject_into_chunk'=>false,
                    'unique'=>false
                ]
                // Add more from examples as needed
            ];
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
                'type'=>'POST',
                'body'=>[
                    'collection_name'=>$name,
                    'field_definitions'=>$field_definitions,
                ],
            ];
            $r=request($request);
        }
        if($a=='collections_get'){
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections',
                'type'=>'GET',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='collection_metadata'){
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid,
                'type'=>'GET',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='collection_remove'){
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid,
                'type'=>'DELETE',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='collection_file_list'){
            extract($arr);
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents',
                'type'=>'GET',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='collection_file_remove'){
            $file_id='';
            extract($arr);
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents/'.$file_id,
                'type'=>'DELETE',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='delete_file'){
            $file_id='';
            extract($arr);
            $request=[
                'link'=>'https://api.x.ai/v1/files/'.$file_id,
                'type'=>'DELETE',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='files_search'){
            extract($arr);
            $request=[
                'link'=>'https://api.x.ai/v1/files',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok'),
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='add_file_to_collection'){
            $file_id='';
            extract($arr);
            pr('https://management-api.x.ai/v1/collections/'.$collectionid.'/documents/'.$file_id);
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents/'.$file_id,
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
                'type'=>'POST',
                'body'=>[
                    'file_id'=>$file_id,
                ],
            ];
            $r=request($request);
            return $r;
        }
        if($a=='rag_upload'){
            $ragid='';
            $collectionid='collection_587362cf-eadc-484a-b986-c56ec9a88793'; // or extract if needed; update to match your curl if different
            extract($arr);
            $rag=fs(aih('rag',['a'=>'get','id'=>$ragid]),0);
            $rag_prms=fs($rag,'params');
            $title=fs($rag_prms,'title');
            $text=fs($rag_prms,'text');
            $name='file_'.$ragid.'.txt';
            $pather=$path.'/crm/php/rare/temper/'.$name;
            file_put_contents($pather,$text);

        
            // Example metadata; adjust based on your needs, e.g., incorporate $title
            $fields=[
                'author'=>'Sandra Kim',
                'year'=>'2024',
                'title'=>$title ?: 'Q3 Revenue Analysis' // use from params if available
            ];
            $content_type='text/plain'; // or 'application/pdf' if file is PDF
        
            $upload_result=upload_to_collection($collectionid, $name, $pather, $content_type, $fields);
            $proxy=explode('—',txt('safe','proxy_us'));
            $proxy=['proxy'=>fs($proxy,0),'username'=>fs($proxy,1),'password'=>fs($proxy,2),];

            $metadata=json_encode($fields);
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                    'Content-Type: multipart/form-data'
                ],
                'proxy'=>$proxy,
                'type'=>'POST',
                'body'=>[
                    'name'=>$name,
                    'data'=> new \CURLFile($pather, $content_type, $name),
                    'content_type'=>$content_type,
                    //'fields'=>$metadata
                ],
            ];
            pr('--');
            $r=request($request);
            pr($r);
            // Optionally unlink($pather); to clean up temp file
            return $upload_result;
        }
        if($a=='add_file_to_collection'){
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                ],
                'type'=>'POST',
                'body'=>[
                    'file_id'=>$file_id,
                ],
            ];
            if(isset($fields)){
                $request['body']['fields']=json_encode($fields);
            }
            $r=request($request);
            return $r;
        }
    }*/
    /*
    if($a=='rag_upload1'){
            $ragid='';
            extract($arr);
            $rag=fs(aih('rag',['a'=>'get','id'=>$ragid]),0);
            $fid=fs($rag,'fid');
            if($fid){
                pr($fid);
                $r=aih('rag',['a'=>'remove_from_collection','file_id'=>$fid,'collectionid'=>$collectionid]);
                pr($r);
                $r=aih('rag',['a'=>'delete_file','file_id'=>$fid]);
                pr($r);
                if(fs($r,'deleted')){
                    sql('set',['id'=>$ragid,'k'=>'fid','remove'=>1,'t'=>'z_rag']);
                }
            }
            $rag_prms=fs($rag,'params');
            $title=fs($rag_prms,'title');
            $text=fs($rag_prms,'text');
            $name='file_'.$ragid.'.txt';
            $pather=$path.'/crm/php/rare/temper/'.$name;
            file_put_contents($pather,$text);

            $metadata=[
                'author'=>'Sandra Kim',
                'year'=>'2024',
                'title'=>'Q3 Revenue Analysis'
            ];
            
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                    'Content-Type: multipart/form-data',
                ],
                'type'=>'POST',
                'body'=>[
                    'name'=>$name,
                    'data'=>new CURLFile(realpath($pather),'text/plain', $name),
                    'content_type'=>'text/plain',
                    'fields'=>json_encode($metadata)
                ],
            ];
            

            $r=request($request);
            pr($r);


            die();
            $request=[
                'link'=>'https://management-api.x.ai/v1/collections/'.$collectionid.'/documents',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok_management_key'),
                    'Content-Type: multipart/form-data',
                ],
                'type'=>'POST',
                'body'=>[
                    'file'=>new CURLFile(realpath($pather),'text/plain',$name),
                ],
            ];
            $request=[
                'link'=>'https://api.x.ai/v1/files',
                'header'=>[
                    'Authorization: Bearer '.txt('safe','grok'),
                    'Content-Type: multipart/form-data',
                ],
                'type'=>'POST',
                'body'=>[
                    'file'=>'@'.$pather.';filename='.$name.';type=text/plain',
                    'purpose'=>'assistants',
                    'file'=>new CURLFile(realpath($pather),'text/plain',$name),
                ],
            ];
            $r=request($request);
            $fid=fs($r,'id');
            if($fid){
                pr($r);
                sql('set',['id'=>$ragid,'k'=>'fid','v'=>$fid,'t'=>'z_rag']);
                $r=aih('rag',['a'=>'add_file_to_collection','file_id'=>$fid,'collectionid'=>$collectionid]);
                pr($r);
            }
            return $r;
        }
*/
function _aih($act='',$arr=[]){//ai helper
    global $path;
    global $global_domain;
    global $lang;
    global $cron_session;
    //fs($_REQUEST,'state') - testing states from manual sigle reruning
    $default_state='intention_detect';
    $test_ai=platform()&&0;
    $max_files=15;
    $max_think_time=4*60;
    if($act=='lock_session'){
        $sessionid='';
        extract($arr);
        $timeout=$max_think_time;// seconds max hold
        $lock_id=uniqid('lk',true);
        $session=fs(aih('get',['t'=>'session','id'=>$sessionid,'force'=>1]),0);
        $sprms=fs($session,'params',[]);
        $cur_lock=fs($sprms,'lock_time',0);
        if($cur_lock && time()-$cur_lock < $timeout){
            return false;// someone else is processing
        }
        sql('set',['id'=>$sessionid,'k'=>'lock_id','v'=>$lock_id,'t'=>'aih_session','prms'=>1]);
        sql('set',['id'=>$sessionid,'k'=>'lock_time','v'=>time(),'t'=>'aih_session','prms'=>1]);
        usleep(30000);// 30ms settle time
        $session=fs(aih('get',['t'=>'session','id'=>$sessionid,'force'=>1]),0);
        $sprms=fs($session,'params',[]);
        if(fs($sprms,'lock_id')!==$lock_id){
            return false;// lost race
        }
        return $lock_id;
    }
    if($act=='unlock_session'){
        $sessionid=$lock_id='';
        extract($arr);
        // only unlock if we own the lock
        $session=fs(aih('get',['t'=>'session','id'=>$sessionid,'force'=>1]),0);
        $sprms=fs($session,'params',[]);
        if(!$lock_id || fs($sprms,'lock_id')===$lock_id){
            sql('set',['id'=>$sessionid,'k'=>'lock_id','remove'=>1,'t'=>'aih_session','prms'=>1]);
            sql('set',['id'=>$sessionid,'k'=>'lock_time','remove'=>1,'t'=>'aih_session','prms'=>1]);
        }
    }
    if($act=='sync_branding') {
        $fgid=$profile=$taskid=$visual_pref='';
        extract($arr);
        $profile_prms=fs($profile, 'params');
        $profile_content=fs($profile_prms, 'content');
    
        $vis=is_array($visual_pref) ? json_encode($visual_pref, JSON_UNESCAPED_UNICODE) : txt_d($visual_pref);
        $ctx=is_array($profile_content) ? json_encode($profile_content, JSON_UNESCAPED_UNICODE) : txt_d($profile_content);
    
        $sys=<<<PROMPT
    You are a senior creative director and visual branding strategist.
    
    Your task: analyze the user's visual preferences and business context, then fill in all brand identity fields using the tool provided.
    
    Rules:
    1. LANGUAGE RULE (CRITICAL — overrides everything):
        - Detect the primary language used in <user_context> text fields.
        - ALL text output in every tool field MUST be written in that detected language. No exceptions.
        - If <user_context> is in Russian, ALL output is in Russian.
        - If <user_context> is in English, ALL output is in English.
        - This applies to: brand_description, meta_description, description_near_text_logo, footer_description.
        - Only brand_name and text_logo may keep their original form if the brand name is in English.
        - Do NOT translate the brand name, but all descriptions, taglines, and copy MUST be in the detected language.
    2. Derive colors strictly from <visual_preferences> color palette — translate color names (e.g. "deep navy blue", "electric violet") into exact HEX codes.
    3. The header gradient should use 2–3 colors from the palette that flow naturally. The button color should be the most vibrant accent color for maximum CTA contrast.
    4. brand_name=the product name exactly as stated in context.
    5. text_logo=exactly two words that work as a visual wordmark (can be the brand name split, or brand + tagline word).
    6. All description fields must be compelling marketing copy — concise, benefit-driven, matching the brand mood described in visual preferences.
    7. Respect all character length limits strictly.
    
    <visual_preferences>{$vis}</visual_preferences>
    <user_context>{$ctx}</user_context>

    FINAL REMINDER: All text output MUST be in the language detected from <user_context>. If the context is in Russian — every description, tagline, and copy field must be in Russian
    PROMPT;
    
        $tools=[];
        $tools[]=[
            'type' => 'function',
            'function' => [
                'name' => 'fill_brand_info',
                'description' => 'Fill all brand identity fields based on visual preferences and business context.',
                'strict' => true,
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'brand_name' => [
                            'type' => 'string',
                            'description' => 'Official brand name as stated in user context. Example: "MetaFunnels"',
                        ],
                        'brand_description' => [
                            'type' => 'string',
                            'description' => 'One-line site tagline for the browser title bar (like WordPress "Site Title | Tagline"). Max 60 chars. Benefit-focused. Must be in the same language as user context.',
                        ],
                        'meta_description' => [
                            'type' => 'string', 
                            'description' => 'SEO meta description for search engines. 120–155 characters. Key benefit + CTA hint. Must be in the same language as user context.',
                        ],
                        'text_logo' => [
                            'type' => 'string',
                            'description' => 'Exactly two words used as a text-based logo/wordmark. Example: "Meta Funnels"',
                        ],
                        'description_near_text_logo' => [
                            'type' => 'string',
                            'description' => 'Short slogan next to the text logo. Max 80 chars. Must be in the same language as user context.',
                        ],
                        'footer_description' => [
                            'type' => 'string',
                            'description' => 'Company description for footer. Max 140 chars. Must be in the same language as user context.',
                        ],
                        'header_menu_color' => [
                            'type' => 'string',
                            'description' => 'CSS gradient for the header/menu background. 2–3 HEX color codes comma-separated, derived from the brand color palette. Example: "#1B2A4A,#6C3FA0,#1B2A4A"',
                        ],
                        'button_color' => [
                            'type' => 'string',
                            'description' => 'Single HEX color for primary CTA buttons. Must be the most vibrant accent color from the palette for high contrast. Example: "#7C3AED"',
                        ],
                    ],
                    'required' => [
                        'brand_name',
                        'brand_description',
                        'meta_description',
                        'text_logo',
                        'description_near_text_logo',
                        'footer_description',
                        'header_menu_color',
                        'button_color',
                    ],
                    'additionalProperties' => false,
                ],
            ]
        ];
        $temper=$path.'/crm/php/rare/temper/result.json';
        if(1){
            $r=ai('send', [
                'model' => 'clds',
                'tools' => $tools,
                'tool_choice' => ['type' => 'tool', 'name' => 'fill_brand_info'],
                'messages' => [
                    ['r' => 's', 'c' => $sys],
                    ['r' => 'u', 'c' => 'Fill in the brand identity fields based on my visual preferences and business context. Write all text fields in the same language as my business context'],
                ]
            ]);
            //file_put_contents($temper,json_encode($r,JSON_UNESCAPED_UNICODE));
        } else {
            //$r=json_decode(file_get_contents($temper),1);
        }
        $tool_calls=fs($r,'tool_calls',[]);
        if($tool_calls){
            $arguments=fs(fs(fs($tool_calls,0),'function'),'arguments');
            if($arguments){
                $brand_name=fs($arguments,'brand_name');
                $brand_description=fs($arguments,'brand_description');
                $meta_description=fs($arguments,'meta_description');
                $text_logo=fs($arguments,'text_logo');
                $description_near_text_logo=fs($arguments,'description_near_text_logo');
                $footer_description=fs($arguments,'footer_description');
                $header_menu_color=fs($arguments,'header_menu_color');
                $button_color=fs($arguments,'button_color');
                $colors=var_get('colors',1);
                $logo=var_get('logo',1);
                var_set('logo',$brand_name,'tt');
                var_set('logo',$brand_description,'ttd');
                var_set('logo',$meta_description,'td');
                var_set('logo',$text_logo,'nm');
                var_set('logo',$description_near_text_logo,'desc');
                var_set('logo',$footer_description,'ft');
                $array2grad=design('array2grad',['array'=>explode(',',$header_menu_color) ]);
                var_set('colors',$array2grad,'mc');
                var_set('colors',$array2grad,'l');
                var_set('colors',$button_color,'btn');
                sql('set',['id'=>$taskid,'k'=>'synced_branding','v'=>1,'t'=>'aih_ent','prms'=>1]);
            }
        }
    }
    if($act=='arch_fg'){
        $fgid=$new_funnel=$is_editing_stage0='';
        extract($arr);
        $fg=fs(jf('get',['id'=>$fgid,'validate'=>1]),0);
        $fg_prms=fs($fg,'params',[]);
        $drawflow=fs($fg_prms,'drawflow_main');
        $drawflow_data=fs(fs(fs($drawflow,'drawflow'),'Home'),'data',[]);
        $stgs=jf('stgs',['validate_on_stage0'=>1,'show_elems'=>1,'force'=>1,'fgid'=>$fgid]);
        //funnel arch
        $funnel_settings=elem('arch',['ui'=>'jf_settings','fgid'=>$fgid]);
        $arch_fg=[];
        $funnel_show_prms=aih('filterBySchema',['schema'=>$funnel_settings,'params'=>$fg_prms]);
        $arch_fg['funnel_settings']=[
            'id'=>$fgid,
            'params'=>['name'=>fs($fg,'name')]+$funnel_show_prms,
        ];
        $vrs=vr('get',['fgid'=>$fgid,'idorder'=>1]);
        $vr_list=jf('vr_list',['fgid'=>$fgid,'idorder'=>1]);
        $vr_list=array_combine(array_column($vrs,'id'),$vrs)+$vrs;
        $varpr=elem('arch',['ui'=>'variables_settings','fgid'=>$fgid]);
        $vrs=[];
        foreach ($vr_list as $key=>$value){
            $vrs[]=['id'=>$value['id'],'params'=>aih('filterBySchema',['schema'=>$varpr,'params'=>['name'=>fs($value,'name')]+fs($value,'params')]) ];
        }
        $plan_list=jf('plan_list',['fgid'=>$fgid]);
        $plan_settings=elem('arch',['ui'=>'plan_settings','schema'=>1,'fgid'=>$fgid]);
        $plns=[];
        foreach ($plan_list as $key => $value){
            $plns[]=['id'=>$value['id'],'params'=>aih('filterBySchema',['schema'=>$plan_settings,'params'=>['name'=>fs($value,'name')]+fs($value,'params')]) ];
        }

        $stages_order=[];
        $arch_fg['entities']=[
            'variables'=>['description'=>'','list'=>$vrs],
            'pricing_plans'=>['list'=>$plns],
        ];
        
        $arch_fg['entities']['variables']['description']='Try to create meaningful but rare names for variables using 3 words divided by underscoremaking sure to not double them with other global variables';
        $arch_fg['stages']=[];

        $stgs_roles=jf('stgs_roles',['fgid'=>$fgid]);
        $nodes_all=atm('nodes',['fgid'=>$fgid]);
        $elems_all=elem('all',['aih'=>1]);

        foreach ($stgs as $stageid =>$stage) {
            $stageid=fs($stage,'id');
            $stages_order[]=$stageid;
            $stage_count=fs($stage,'count',0);
            $stage_roles=fs($stage,'roles');
            $stage_map=['id'=>$stageid,'role'=>'','description'=>'Stage №'.$stage_count.(!$stage_count?'; This stage is holder for landing page and global triggers':''),'params'=>['name'=>fs($stage,'name')],'roles'=>[]];
            if(!$stage_count){
                $stage_map['role']='stage'.$stage_count;
            } else {
                unset($stage_map['role']);
            }
            foreach ($stgs_roles as $role=>$someinfo){
                if(!$stage_count&&!fs($someinfo,'stage0')){
                    continue;
                }
                $struct=[];
                $nodes=[];
                $order=[];
                $fin=[];
                if(strp('follow',$role)){
                    $fin['params']=['hours'=>fs($stage,'hours_'.num($role)),'minutes'=>fs($stage,'minutes_'.num($role),0)];
                }
                foreach (fs(fs($stage_roles,$role),'elems',[]) as $somekey=>$node){
                    $nodeid=fs($node,'id');
                    //$drawflow_data
                    $order[]=$nodeid;
                    $node_type=fs($node,'type');
                    $node_arch=elem('arch',['type'=>$node_type,'fgid'=>$fgid]);
                    $node_prms=fs($node,'params');
                    $node_data=['id'=>$nodeid,'type'=>$node_type,'params'=>[]];
                    $outputs_o=fs(fs($drawflow_data,$nodeid),'outputs',[]);
                    $outputs=[];
                    if($node_type=='page'){
                        $pageid=fs($node_prms,'pageid');
                        $func=fs(func('get',['id'=>$pageid,'elems'=>1]),0);
                        $func_prms=fs($func,'params');
                        $prms=$func_prms;
                        $node_data['blocks']=[];
                        $node_data['order']=[];
                        
                        foreach (fs($func,'elems',[]) as $elemid=>$el){
                            $add_prms=[];
                            $el_type=fs($el,'type');
                            $node_data['order'][]=$elemid;
                            $el_type_pretty=fs(fs($elems_all,$el_type),'slug');
                            $el_prms=fs($el,'params',[]);
                            $el_arch=elem('arch',['type'=>$el_type,'noai_common'=>1,'fgid'=>$fgid]);
                            foreach ($el_prms as $key=>$value) {
                                $el_prms[$key]=txt_d(json_d($value));
                            }
                            $el_prms_e=aih('filterBySchema',['schema'=>$el_arch,'params'=>$el_prms]);
                            
                            if($el_type=='qz'){
                                $qzid=fs($el_prms,'qzid');
                                $qz=fs(qz('get',['id'=>$qzid]),0);
                                if($qz){
                                    $qz_prms=fs($qz,'params');
                                    $qz_prms['name']=fs($qz,'name');
                                    $qz_settings=elem('arch',['ui'=>'qz_settings','fgid'=>$fgid]);
                                    $qz_prms_e=aih('filterBySchema',['schema'=>$qz_settings,'params'=>$qz_prms]);
                                    $el_prms_e=$el_prms_e+$qz_prms_e;
                                    $slide_map=fs($qz,'slide_map',[]);
                                    //fields id 
                                    $add_prms['slides']=[];
                                    $qz_slide_settings=elem('arch',['ui'=>'quiz_slide','fgid'=>$fgid]);
                                    $slide_funcs=func('get',['id'=>fs($qz_prms,'order'),'idorder'=>1,'elems'=>1]);
                                    foreach ($slide_map as $skey => $slide){
                                        $slideid=fs($slide,'id');
                                        $ref_slide=fs($slide_funcs,$slideid);
                                        $selems=fs($ref_slide,'elems',[]);
                                        $tblocks=[];
                                        foreach ($selems as $telid=>$tel){
                                            $tel_type=fs($tel,'type');
                                            $tel_type_pretty=fs(fs($elems_all,$tel_type),'slug');
                                            $tel_prms=fs($tel,'params',[]);
                                            foreach ($tel_prms as $keyt=>$valuet) {
                                                $tel_prms[$keyt]=txt_d(json_d($valuet));
                                            }
                                            $tel_arch=elem('arch',['type'=>$tel_type,'noai_common'=>1,'fgid'=>$fgid]);
                                            $tel_prms_e=aih('filterBySchema',['schema'=>$tel_arch,'params'=>$tel_prms]);
                                            $tblock=['id'=>$telid,'type'=>$tel_type_pretty,'params'=>$tel_prms_e];
                                            $tblocks[]=$tblock;
                                        }
                                        $slide_prms=fs($ref_slide,'params',[]);
                                        $slide_prms_e=aih('filterBySchema',['schema'=>$qz_slide_settings,'params'=>$slide_prms]);
                                        $sld=['id'=>fs($slide,'id'),'params'=>$slide_prms_e,'blocks'=>$tblocks,'order'=>implode(',',array_keys($selems))];
                                        $add_prms['slides'][]=$sld;
                                    }
                                    
                                    //die();
                                    /*
                                    pr($qz_prms_e);
                                    die('kk');
                                    pr($qz);
                                    die();*/
                                }
                            }
                            $eler=['id'=>$elemid,'type'=>$el_type_pretty,'params'=>$el_prms_e]+$add_prms;
                            $node_data['blocks'][]=$eler;
                        }
                        $node_data['order']=implode(',',$node_data['order']);
                        $elem_events=jf('elem_events',['fgid'=>$fgid,'force'=>1,'fg'=>$fg,'outputs'=>1,'drawflow'=>$drawflow,'elemid'=>$nodeid,'func'=>$func,'funcid'=>fs($func,'id')]);
                        $outputs=[];
                        $countout=0;
                        foreach (fs($elem_events,'map') as $k22=>$v22){
                            $countout++;
                            $to_node=fs(fs(fs($v22,'outputs'),0),'node');
                            $valler=['name'=>fs($v22,'n'),'event'=>fs($v22,'action')];
                            if($to_node){
                                $valler['to_node']=$to_node;
                                $valler['from_block_id']=fs($v22,'elemid');
                            }
                            $outputs['output_'.$countout]=$valler;
                        }
                    } else {
                        $prms=$node_prms;
                        foreach ($outputs_o as $k11=>$v11){
                            foreach (fs($v11,'connections',[]) as $k22=>$v22){
                                $noder=fs($v22,'node');
                                $valler=['to_node'=>$noder];
                                $outputs[$k11]=($noder?$valler:[]);
                            }
                        }
                    }
                    if($outputs){
                        $node_data['outputs']=$outputs;
                    }
                    //remove json_d
                    foreach ($prms as $key=>$value) {
                        $prms[$key]=txt_d(json_d($value));
                    }
                    $prms=aih('filterBySchema',['schema'=>$node_arch,'params'=>$prms]);
                    $node_data['params']=$prms;
    
                    //notes
                    $default_keyword=jf('default_keyword');
                    if($node_type=='trigger'&&!$stage_count&&strp($default_keyword,json_encode($prms,JSON_UNESCAPED_UNICODE))){
                        $node_data['description']='Key word '.$default_keyword.' is default, make sure to replace with relevant word';
                    }
                    if($node_type=='page'&&!$stage_count&&$new_funnel&&$is_editing_stage0){
                        $node_data['description']='Best option for landing page header "socials"; And try to start landing page from [image with "entron"="btn"],then [text_editor with "mp"=1] h2 heading and best product achievements in list,then [button] and then as you wish';
                    }
                    $nodes[]=$node_data;
                }
                //$struct['nodes']=$nodes;
                
                if($nodes){
                    $fin['nodes']=$nodes;
                }
                if($order){
                    $fin['order']=implode(',',$order);
                }
                $stage_map['roles'][$role]=$fin;
            }
            $arch_fg['stages'][]=$stage_map;
        }
        $arch_fg['order']=implode(',',$stages_order);
        return $arch_fg;
    }
    if($act=='arch_pl'){
        $fgid=$elem_arch=$noelems=$for_strategy='';
        extract($arr);
        $fgid=($fgid?:fs(fs(fg('get',['type'=>20]),0),'id'));
        $stgs=jf('stgs',['fgid'=>$fgid]);
        lang('en','aih');
        $pay_ways=pay('ways',['idorder'=>1]);
        $chatbots=chatbots();
        $available=[];
        foreach ($chatbots as $key=>$value) {
            if(fs($value,'on')){
                $available[]=fs($value,'n');
            }
        }
        if($for_strategy){
            $noelems=1;
        }
        $available=implode(',',$available);
        $broadcasting=[];
        $window24hours=[];
        $chat_or_channel=[];
        foreach ($chatbots as $key=>$value) {
            if(!fs($value,'on')){
                continue;
            }
            if(!fs($value,'sess')){
                $broadcasting[]=fs($value,'n');
            } else {
                $window24hours[]=fs($value,'n');
            }
            if(fs($value,'group_chat_support')){
                $chat_or_channel[]=fs($value,'n');
            }
        }
        $window24hours=implode(',',$window24hours);
        $broadcasting=implode(',',$broadcasting);
        $pay_ways_list=[];
        $reccuring_payments=[];
        foreach ($pay_ways as $key=>$value) {
            $pay_ways_list[]=fs($value,'name');
            if(fs($value,'sub')){
                $reccuring_payments[]=fs($value,'name');
            }
        }
        //add menu on instagram
        $elem_all=elem('all',['aih'=>1]);
        $t_fielde=fs(fs($elem_all,'fielde'),'name');
        $nodes_all=atm('nodes');
        $nodes=atm('nodes',['aih'=>1]);
        $reccuring_payments=implode(',',$reccuring_payments);
        $pay_ways_list=implode(',',$pay_ways_list);
        $work='';
        $work.='The main goal of the platform is to create revenue funnel strategies for clients'."\n";
        $work.='CHANNELS - that can be connected to the platform: '.$available."\n";
        $work.='Our platform works like ManyChat flow node editor and other competitors but our main difference: we have UI focused on funnel stages and key actions; we also have website builder and separate website nodes on nodes flow which could be doubleclicked to enter and edit each block'."\n";
        $work.='Platform owner — OWNER can edit everything in their platform'."\n";
        $work.='At the moment, the platform does not support E-mail marketing'."\n";
        $work.='Channels that support broadcasting on contacts list outside 24 hours window: '.$broadcasting."\n";
        $work.='Make sure if you make strategy appliable for '.$window24hours.', automation should be inside 24-hour window or extendable by gettting feedback in funnel logic'."\n";
        $work.='We have own CRM with customer cards CONTACT, ui for payments list, ui for monthly subscription list, ui for creating pricing plans'."\n";
        //$work.='Payment methods: '.$pay_ways_list.'';
        $work.='About 30 payment methods for different countries: more at '.$global_domain.'/crm/?page=payments&tab=methods'."\n";
        $work.='Support of recurring payments for several of payment methods'."\n";
        //$work.='Recurring support: '.$reccuring_payments;
        $work.='We have own website builder and node editor for sending messages and other logic'."\n";
        $work.='Websites can be added in the node-based UI. Connections can be drawn to them from other nodes and buttons, and each site can be opened and edited by modifying its individual blocks'."\n";
        
        
        $stages='';

        // ── FUNNEL OVERVIEW ──
        $stages .= "A funnel guides clients through a customer journey (sales, education, onboarding, etc.) divided into sequential stages.\n";
        $stages .= "Each stage holds exactly ONE Key Action (KA) — the single thing the client must do to advance (e.g. watch a video, fill a form, make a payment).\n\n";

        // ── ENTITY HIERARCHY (levels of depth) ──
        $stages .= "ENTITY HIERARCHY (schema):\n";
        $stages .= json_encode([
            "funnel"=>[
                "stages"=>[
                    "stage"=>[
                        "role_page"   =>["max"=>1, "type"=>"page", "children"=>"site_blocks, quiz > quiz_slides > site_blocks"],
                        "role_init"   =>["max"=>1, "type"=>"message", "required_on"=>"stage1+"],
                        "role_follow" =>["max"=>3, "type"=>"message", "required_on"=>"stage1+"],
                        "role_trigger"=>["type"=>"trigger", "scope"=>"global on stage0, local on stage1+"],
                        "role_support"=>["type"=>"any nodes"],
                        "role_next"   =>["max"=>1, "type"=>"stage_next", "required"=>true]
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT)."\n\n";
        // ── STAGE ROLES & RULES ──
        $stages .= "STAGE ROLES — each stage uses these role slots:\n\n";

        $stages .= "role_page (MAIN PAGE):\n";
        $stages .= "  - Max 1 per stage. Optional for stages 1+. Required for stage 0 (landing page).\n";
        $stages .= "  - Contains site blocks that present the KA content.\n";
        $stages .= "  - Page outputs (button events, quiz completion, plan purchase) connect to stage_next to advance the client.\n\n";

        $stages .= "role_init (initial message):\n";
        $stages .= "  - Exactly 1 per stage. Required for stages 1+. NOT present on stage 0.\n";
        $stages .= "  - Could be multiple init messages f.g when we need to send image+text and video.\n";
        $stages .= "  - Auto-sent when client enters the stage — no manual connection from stage_next needed.\n";
        $stages .= "  - Explains what the client should do now (the KA). Sells the reason to act.\n";
        $stages .= "  - If stage has a MAIN PAGE, include a button with \"t\":\"stage_page\" to link to it automatically.\n\n";

        $stages .= "role_follow (follow-up messages):\n";
        $stages .= "  - Up to 3 per stage. Required for stages 1+. NOT present on stage 0.\n";
        $stages .= "  - Could be multiple same as init messages.\n";
        $stages .= "  - Sent automatically at preset delays (typically 1h / 2h / 23h) if KA is not yet completed, these settings are placed in follow up role don't set delay_h manually.\n";
        $stages .= "  - Do NOT need manual time-delay or variable-check nodes — presets handle this.\n";
        $stages .= "  - Do NOT need connections to/from init or each other — they are independent.\n";
        $stages .= "  - If stage has a MAIN PAGE, include a button with \"t\":\"stage_page\" on each follow-up.\n";
        $stages .= "  - Each message uses different copywriting arguments to persuade the client to complete KA.\n\n";

        $stages .= "role_trigger:\n";
        $stages .= "  - On stage 0: GLOBAL triggers (keyword entry, bot_ref_link — bot_ref_link added automatically).\n";
        $stages .= "  - On stages 1+: LOCAL triggers scoped to that stage only (e.g. a keyword to pass a lesson).\n";
        $stages .= "  - Outputs connect to stage_next.\n\n";

        $stages .= "role_support:\n";
        $stages .= "  - Any number of additional nodes (extra pages, conditions, CRM actions, notes, etc.).\n";
        $stages .= "  - No triggers allowed here.\n";
        $stages .= "  - Optional. Used for branching logic, notifications, or supplementary content.\n\n";

        $stages .= "role_next (stage_next node):\n";
        $stages .= "  - Minimum 1 per stage. Required on every stage.\n";
        $stages .= "  - Could be multiple if have some events or buttons to send clients to certain stages through 'dest_type' node.\n";
        $stages .= "  - Receives connections from KA-completion outputs (page events, triggers, etc.).\n";
        $stages .= "  - Sends client to the next stage, auto-triggers that stage's initial message, and opens its MAIN PAGE if any.\n\n";

        // ── STAGE 0 (ENTRANCE) — special rules ──
        $stages .= "STAGE 0 — ENTRANCE (special rules):\n";
        $stages .= "  - Purpose: authorize the user and bring them into the funnel.\n";
        $stages .= "  - Has: landing page (role_page, required), trigger node (role_trigger, required), stage_next (role_next, required).\n";
        $stages .= "  - Does NOT have: initial message, follow-up messages.\n";
        $stages .= "  - Landing page buttons use \"tochatbot\" to subscribe users via a CHANNEL.\n";
        $stages .= "  - Trigger node: set keyword conditions; bot_ref_link is added automatically.\n";
        $stages .= "  - All outputs (landing buttons + trigger outputs) connect to stage_next → stage 1.\n\n";

        // ── STAGES 1+ (CONTENT STAGES) — standard structure ──
        $stages .= "STAGES 1+ — STANDARD STRUCTURE:\n";
        $stages .= "  Required: role_next (1).\n";
        $stages .= "  Optional: role_init (1), role_follow (up to 3) recommended, role_page (max 1 MAIN PAGE), role_trigger, role_support.\n";
        $stages .= "  Flow: client enters → init message auto-sent → client visits MAIN PAGE (if any) → completes KA → output connects to stage_next → next stage.\n";
        $stages .= "  If KA not completed: follow-up messages fire at preset intervals.\n\n";

        // ── LAST STAGE ──
        $stages .= "LAST STAGE:\n";
        $stages .= "  - Typically the purchase with instructions messages or final conversion stage.\n";
        $stages .= "  - In some rare cases we could send client to other paid funnel through stage_next to stage 1 of another funnel.\n";
        $stages .= "  - Does not require stage_next (no further stage to advance to).\n\n";

        // ── TRANSITION RULES ──
        $stages .= "TRANSITION RULES:\n";
        $stages .= "  - Every non-last stage MUST have a path from KA completion to stage_next.\n";
        $stages .= "  - Exception: manual_sending_to_next_stage — OWNER checks tasks and sends 'Checked' in chat to advance the client.\n";
        $stages .= "  - If a page output connects to stage_next, the client is taken directly to the next stage's MAIN PAGE (if any) and the init message is also sent.\n";
        $stages .= "  - Clients should be able to progress through all pages from first to last KA without returning to chatbot. Messages are support/follow-up elements, not required reading.\n\n";

        // ── KEY CONSTRAINTS ──
        $stages .= "KEY CONSTRAINTS:\n";
        $stages .= "  - ONE KA per stage. Never ask the client for multiple actions in one stage.\n";
        $stages .= "  - ONE MAIN PAGE per stage maximum.\n";
        $stages .= "  - 3 follow-up messages maximum per stage.\n";
        $stages .= "  - 1 initial message per stage (stages 1+).\n";
        $stages .= "  - stage_next and stages themselves eliminate the need for manual variable tracking of KA progress.\n";
        $stages .= "  - init and follow-up messages with \"t\":\"stage_page\" buttons auto-link to MAIN PAGE — no manual node connections needed for this.\n";

        $strat='';
        $strat.='Since the platform is deeply focused on messenger-based strategies, the primary goal is to bring users into a chatbot and capture their contact, then send marketing messages to drive them toward a key action using different arguments and messages'."\n";
        $strat.='Every funnel should follow the A-I-D-A framework: Attention → Interest → Desire → Action. Stage 0 (landing/entry) captures Attention. Early stages build Interest by delivering value and context. Middle stages create Desire through proof, benefits, and emotional triggers. Final stages drive Action — the purchase or conversion. When designing stages, messages, and pages, always map content to the appropriate AIDA phase';
        $strat.='If in funnel we use videos try to send them not in chatbot but on site page as there we have special convinient block with video player'."\n";
        $strat.='If in funnel we use pricing plans put them on page also'."\n";
        $strat.='The strategy can be any approach that fits within the platform’s capabilities'."\n";
        $strat.='User strategy could also be an educational course where we have from 2-300 and more lessons (pages) where we could have videos and different other blocks, each page is new stage'."\n";
        $strat.='Try to build simple funnels focusing on content that users will receive: sites, messages, video, pictures, some conditions, to block or show some content etc. Refuse to create hard strategies outside simple functionality we provide or other API integrations, API only for programmers at Global Settings, you can\'t handle it correctly'."\n";
        $strat.='If OWNER is an infopreneur selling their knowledge or skills, be sure to include a way to get their consultation by clients via the "manager" block on a first stage page. This strategy is necessary to encourage people to also message OWNER directly, so the owner can communicate with potential clients via voice messages and sell before full funnel is completed'."\n";
        $strat.='Also a popular strategy is to organize users funnel as a set of lessons with tasks that clients should complete; each task makes frendship and deal closer; OWNER can send clients to next stages manually after real live feedback (see manual_sending_to_next_stage) or automatically though nodes; '."\n";

        $manual=edu('manual_sending_to_next_stage',['array'=>1]);

        $initm='';
        $initm.='Every stage should have initial message because it describes what to do now for clients, but follow-up messages will be sent under certain conditions'."\n";
        $initm.='initial message is triggered automatically after client reaches stage_next node; so it doesn\'t have any connection'."\n";
        $initm.='initial message should sell the idea to make key action of stage by different marketing triggers'."\n";
        $initm.='initial message buttons could lead to page or other support messages'."\n";

        $fup='';
        $fup.='Follow-up messages is the main strategy to make visitors complete key actions'."\n";
        $fup.='Each KA should be supported by multiple follow-up messages, best is 3 messages'."\n";
        $fup.='You should track user actions by node outputs "trigger" or "page" (f.g first visit, quiz completion, payment, etc) and then connect them to stage_next to go to next stage'."\n";
        $fup.='If user didn\'t make KA we could send follow-up messages one after 1 hour since entering the stage, second after 2 hours and third after 23 hours to make shure to fit in 24 hours window'."\n";
        if(!$noelems){
            $fup.='Always use the best copywriting to describe the reason why a client should complete KA'."\n";
        }

        $m='';
        $m.='If you write a text for message and you plan to use "bn" write as a separate <p> call to action to click on it with winger emoji'."\n";
        $m.='Always prefer set up first init message "t" as image and fill "img_prompt" if there are no "img" param'."\n";
        $m.='For follow up messages you prefer to use "t"=text message unless user asks explicitly'."\n";
        $messages_best_practices=$m;

        $sttrig='';
        $sttrig.='trigger role placeholder in stage for nodes has 2 functions'."\n";
        $sttrig.='trigger events could be global when it is placed on stage №0 role or local only for any current stage'."\n";
        $sttrig.='F.g if we need to identify a keyword that will be used globally by any client on platform to enter the funnel we could put it in global role_trigger of stage №0'."\n";
        $sttrig.='Or if we need some key word to pass current stage of the funnel we could use "lesson 3" keyword in local role_trigger of stage 2 to pass the next stage'."\n";
        $sttrig.='Stage triggers help to avoid spamming different local trigger events on whole platofrm globally if we need some local trigger once per stage and never further'."\n";


        $prps=$prp='';
        if(!$noelems){
            $prps.='We have a separate pricing plan entity and same block. One pricing plan created as entity gets it\'s ID and can be set it in plan block with "planid"=ID '."\n";
        }
        $prps.='Never create pricing plans for 0 price, because the functionality of validation card and then taking money is very limited by most payment systems'."\n";
        $prps.='Use simple pricing strategies and simple pricing plans nothing sophisticated'."\n";
        if(!$noelems){
            $aih=elem('arch',['ui'=>'plan_settings','fgid'=>$fgid]);
            $prp=$aih;
            $prp['description']=$prps.(fs($prp,'description')?' '.fs($prp,'description'):'');
        }

        $aih=elem('arch',['ui'=>'quiz_slide','fgid'=>$fgid]);
        $quiz_slides=$aih;
        

        $aflt='';
        $aflt.='We have features for affiliate marketing:'."\n";
        $aflt.='OWNER could set up rules in affiliate program settings: how much commission to pay for each referral, how many levels of referrals, how much commission to pay for each level, which products to pay commission for, which products to exclude from commission, etc.'."\n";
        $aflt.='UI has ability to view all clients in a tree structure showing who invited whom; The interface does not handle payouts — clients must define payout methods with their legal and accounting teams — but UI helps to calculate amounts owed and notifies partners about earned commissions'."\n";
        $aflt.='Platform also sends notifications by default to partners when they have registered referral, or payed for something you don\'t have to setup such notifications by node "'.fs(fs($nodes,'tnote'),'name').'" -> "'.fs(atm('t_tnote_type'),'aflt').'" '."\n";
        $aflt.='If user plan to go deep in affiliate you can create a separate page for affiliate managment by our clients in funnel and give access to it to clients in certain steps of the funnel'."\n";
        $aflt.='That page could help clients easily manage tools for growth. Look at "affiliate_site_blocks" there are some rare blocks that could be helpfull. F.G: this page could have 1 video with motivational speech about affiliate marketing, block with affiliate rules, block with affiliate links (with ?ref= attribute) to certain landing page of the funnel or direct node link that can be copied by users, block with affiliate tree view to see invited referals in given level depth, UTM analytics. This approach is for owners who want to heavily invest in an affiliate program and is not required for everyone'."\n";
        

        $auth='';
        $auth.='We have 2 states of users: unauthorized and authorized'."\n";
        $auth.='Authorized users could get messages, make payments, appear in CRM, could have long storing variables'."\n";
        $auth.='Unauthorized users can visit sites, fill forms in "'.$t_fielde.'" in quizzes and their variables will be stored short time during one session. If such user becomes authorized, their variables will be merged in new authorized CONTACT user'."\n";
        $auth.='We have stage №0 to authorize users via landing page with "tochatbot" button or direct link to node "trigger" node or some key word'."\n";

        $landp='';
        $landp.='Landing page is №0 stage because it is just sends users to the first stage via stage_next to initial message, it is just another way to enter the funnel'."\n";
        $landp.='Some clients could never see landing page because they have entered through Instagram or key word in other CHANNELS'."\n";
        $landp.='Landing page button with "tochatbot" option gives clients many options to subscribe through different CHANNELS so some OWNERS could give that link to landing page in ads to give their clients ability to select CHANNEL to subscribe'."\n";
        $landp.='But direct access to funnel from link or word often gives higher coversions because instead of reading a page and miss conversion we could instead send follow-up messages from first seconds to complete first KA'."\n";
        $landp.='OWNER could not use Landing Page at all if they use only one channel to give their clients link to direct funnel access'."\n";
        $landp.='Recommended for landing to have several "btn" with "tochatbot" on each mobile screens; 2-3 blocks is one mobile screen'.(!$noelems?'; First button must be at first screen and could be inside first image below as "entron"="btn"':'')."\n";

        
        $pstr='';
        $pstr.='As Instagram site enterance to chatbot is blocked, you should use it only for landing page to autorize other CHANNELS'."\n";
        $pstr.='After authorization, strategy may need to have pages. Don\'t use buttons on pages to send clients back to chatbot, instead send them to next_stage or other pages for completing stages'."\n";
        $pstr.='If page output is connected to stage_next, it will lead client to the next page of the next stage directly (if we have it). Initial message will be sent also after transition'."\n";
        $pstr.='We don\'t need to send clients back to chatbot, chatbot is just for sending follow-up and initial messages'."\n";
        $pstr.='If our KA is watching a video and we have a button to the next page under the video a good prctice is to add "t_show" and "t_show_t" to 60 seconds for button block settings to show the button after 60 seconds to pervent clients clicking on the next TA without watching the video'."\n";
        $pstr.='If we have a funnel with pages, clients should have ability to go through funnel from first page to last KA without returning to chatbot and reading messages, because messages in most cases are just support elements for guiding and following-up. If a client could go through all pages and KA without even reading messages it is a good sign of effective funnel'."\n";

        $var='';
        $var.='The customer journey logic can be controlled using variables. Variables can be provided directly by users through "'.$t_fielde.'" or assigned via the node editor logic to change user paths—such as sending or skipping specific messages'."\n";
        $var.='Variables can also be used to hide or display any site block based on whether a variable is present or not'."\n";
        $var.='Platform has list of system variables and ability to create custom variables'."\n";
        $var.='Variables works almost in every text property of blocks and nodes within figure brackets: {variable_name} both for system and custom variables'."\n";
        if(!$noelems){
            $var.='If you want to add variables in text properties (f.g in message or text_editor) use their name in figure brackets: {variable_name} but when you need to add variable in values such as "vr" or "vr_set_vrid" set variable ID'."\n";
        }
        
        $varpr=elem('arch',['ui'=>'variables_settings','fgid'=>$fgid]);
        


        $quiz='A quiz is a powerful tool that allows multiple slides to be created on a single site page'."\n";
        $quiz.='First slide is always visible fully, when a client clicks on any content on quiz, this separate block becomes focused and other blocks become hidden until user clicks Close button to go back'."\n";
        $quiz.='Each slide functions like a separate page and can contain any site blocks'."\n";
        $quiz.='Slides are shown in a defined order, and each slide includes a Next button to move forward'."\n";
        $quiz.='Quizzes are most commonly used to collect client\'s data through several "'.$t_fielde.'" per slide'."\n";
        $quiz.='Rare case after filling a quiz we could send client to a CHANNEL to authorize them and start funnel from there all variables will be merged (quiz should be placed on landing page with "tochatbot" button on last slide), except this case never use "tochatbot" button here'."\n";
        $quiz.='The last slide must always be a thank-you slide with at least one button. That button must use b_act=topage or tochatbot to send the client to the next stage or connect to stage_next. Never leave the last slide without a navigation button, as the client will have no way to proceed'."\n";
        $quiz.='Always have 2 or more pages in quiz because only then we could have trigger Quiz completed after sliding to last page'."\n";
        $quiz.='You don\'t have to manualy save "'.$t_fielde.'" through nodes because this block has "vr" setting to store variable'."\n";
        $quiz.='Group easy questions on single slide; hard and long on other slides'."\n";
        $quiz.='Important: Don\'t put any input fields on last slide because when client see it trigger is fired without waiting for filling rest fields'."\n";
        $quiz_structure=[
            'block_quiz_id'=>[
                'slide_id'=>[
                    ['block with explanation why to fill this field','several blocks or fields']
                ],
                'slide_id_2'=>[
                    ['several blocks']
                ],
                'last_slide_id'=>[
                    ['finishing blocks with some call to action']
                ],
            ],
        ];

        $nodes_index=[];
        foreach ($nodes_all as $key=>$value){
            if(in_array('one',fs($value,'outputs_policy',[])) ){
                $nodes_index[]=$key;
            }
        }

        $list_events=fs(jf('elem_events',['aih'=>1,'fgid'=>$fgid]),'base');
        foreach ($list_events as $key=>$value) {
            $block=fs($value,'block');
            $slg=fs(fs($elem_all,$block),'slug',$block);
            $list_events[$key]['produced_by']=$slg;
            $list_events[$key]['desc']=$list_events[$key]['name'].' '.$list_events[$key]['desc'];
            unset($list_events[$key]['name']);
            unset($list_events[$key]['block']);
        }
        
        $nouts='';
        $nouts.='Almost each node has inputs and outputs: several, one or none. Except trigger nodes could have unlimited outputs; See outputs_description field in each node to understand how it works'."\n";
        
        $outpol=[
            'connection_rules'=>[
                'Each output supports only ONE connection. New connection overwrites the previous one.',
                'Each input can receive multiple connections.',
            ],
        
            'index_calculation'=>[
                'description'=>'For output_index in node connections of edit_funnel tool. All indexes are 1-based.',
                
                'single_output_nodes'=>[
                    'nodes'=>$nodes_index,
                    'rule'=>'Always output_index=1',
                ],
                
                'message'=>[
                    'rule'=>'Output 1=NEXT (always). Each button in bn adds +1 starting from 2.',
                    'CRITICAL'=>'ALL buttons count for index position regardless of type (stage_page, jf, cu). Even though only jf buttons produce connectable outputs, stage_page and cu buttons still occupy index slots.',
                    'example'=>[
                        'bn'=>[
                            '0: {n: "Watch video", t: "stage_page"}',
                            '1: {n: "Details", t: "jf"}',
                            '2: {n: "Buy", t: "jf"}',
                        ],
                        'outputs'=>[
                            '1=NEXT',
                            '2="Watch video" (stage_page — auto-wired, NOT connectable, but OCCUPIES index 2)',
                            '3="Details" (jf — connectable)',
                            '4="Buy" (jf — connectable)',
                        ],
                        'to_connect_Details'=>'output_index=3, NOT 2',
                    ],
                ],
                
                'condition'=>[
                    'rule'=>'1..N=groups in array order, N+1=no conditions met',
                ],
                
                'trigger'=>[
                    'rule'=>'1..N=triggers in array order',
                ],
                
                'randomizer'=>[
                    'rule'=>'1..N=chances in array order',
                ],
            ],
        
            'page_events'=>[
                'description'=>'For page_event node connections of edit_funnel tool. No index needed — use block_id + event.',
                'events'=>$list_events,
            ],
        ];


        $aigen='';
        $aigen.='Recently, among clients in the infobusiness space, a popular strategy is solving customer problems using AI generators'."\n";
        $aigen.='We have several simple AI generators that produces text, images, images analysis'."\n";
        $aigen.='F.G: If OWNER works in marketing. We could get different information trough quiz and several "'.$t_fielde.'" which save customer data in {variables} about their clients pain points and using "'.fs(fs($elem_all,'ai_prompt'),'name').'" we could generate analysis of their business. We add to "prompt" property of this ai block client variables and our custom prompt that leads AI to selling OWNER marketing approach besides analysis of given data'."\n";
        $aigen.='Look closer at "ai_site_blocks" to see list of all generators blocks'."\n";
        $aigen.='This platform has its own AI wallet from which funds are deducted for AI requests. If AI generators are provided to clients, costs can be charged either from this wallet or the generators can require topping up the platform wallet. This creates a virtual wallet for each client when the platform owner relies on strategies that provide AI generation to users'."\n";


        $groups='';
        $groups.='Platform supports entity group chat or channel CHAT_OR_CHANNEL provided by some chatbots: '.implode(', ',$chat_or_channel)."\n";
        $groups.='Some actions can be performed related to CHAT_OR_CHANNEL f.g: sending a message to chat, or trigger event when someone joined group chat or channel, or check subscription to channel to send a bonus'."\n";
        $groups.='If you see node or block property CHAT_OR_CHANNEL, please ad ID of related entity from list below';


        $blockdesc='';
        $blockdesc.='Each block has unique set of properties and default provided below at "default_properties_for_each_block" section. You can set up it for any block';
        //

        //page events
        //qz
        //переменные
        //скрытие переменных
        $site_blocks=[];
        $ai_site_blocks=[];
        $alft_site_blocks=[];
        $elem_arch_default='';
        foreach ($elem_all as $key=>$value){
            $slug=fs($value,'slug',$key);
            unset($value['slug']);
            if(!$noelems){
                $elem_arch=elem('arch',['type'=>$key,'default'=>1,'fgid'=>$fgid]);
                $elem_desc=fs($elem_arch,'description');
                $value['description']=$elem_desc;
                $properties=fs($elem_arch,'properties',[]);
                $value['properties']=$properties;
                $elem_arch_default=fs($elem_arch,'default');
            }
            if(substr($key,0,3)=='ai_'){
                $ai_site_blocks[$slug]=$value;
            } else if(substr($key,0,5)=='aflt_'){
                $alft_site_blocks[$slug]=$value;
            } else {
                if($slug=='quiz'){
                    $qz_settings=elem('arch',['ui'=>'qz_settings','fgid'=>$fgid]);
                    $value['properties']=fs($value,'properties',[])+fs($qz_settings,'properties',[]);
                }
                $site_blocks[$slug]=$value;
            }
        }
        foreach ($nodes as $key=>$value){
            if(!$noelems){
                $elem_arch=elem('arch',['type'=>$key,'fgid'=>$fgid]);
                $elem_desc=fs($elem_arch,'description');
                $value['description']=$elem_desc;
                $properties=fs($elem_arch,'properties',[]);
                $value['properties']=$properties;

            }
            $nodes[$key]=$value;
        }

        $funnel_settings=elem('arch',['ui'=>'jf_settings','fgid'=>$fgid]);

        $var_list=[];
        $variables=elem('variables',['jf_force'=>1,'cbf'=>1,'array'=>1]);
        foreach ($variables as $key=>$value){
            $e=fs($value,'e');
            $var_list[sr($key,['{','}'],'')]=fs($value,'d').($e?' '.$e:'');
        }

        if($noelems){
            $site_blocks=array_values($site_blocks);
            $ai_site_blocks=array_values($ai_site_blocks);
            $alft_site_blocks=array_values($alft_site_blocks);
            $nodes=array_values($nodes);
        }
        lang('back','aih');
        $list_chats=chat('chats',['all'=>1,'select'=>1,'full_info'=>1,'dd'=>[]]);
        $res=[
            'platform'=>$work,
            'stages'=>$stages,
            'strategy_recommendations'=>$strat,
            'manual_sending_to_next_stage'=>$manual,
            'authorization'=>$auth,
            'landing_page'=>$landp,
            'pages_strategy'=>$pstr,
            'initial_message'=>$initm,
            'follow-up_strategy'=>$fup,
            'messages_best_practices'=>$messages_best_practices,
            'trigger_role'=>$sttrig,
            
            'variables'=>[
                'description'=>$var,
                'system_variables'=>$var_list,
            ],
            'entity_properties'=>[
                'stages'=>elem('arch',['ui'=>'stgs_setts','fgid'=>$fgid]),
                'variables'=>$varpr,
                'pricing_plans'=>$prp,
                'quiz_slides'=>$quiz_slides,
            ],
            'node_outputs'=>$nouts,
            'node_outputs_policy'=>$outpol,
            'quiz'=>['description'=>$quiz,'structure'=>$quiz_structure],
            'ai_generators'=>$aigen,
            'affiliate_marketing'=>$aflt,
            'group_chats_and_channels'=>[
                'description'=>$groups,
                'list'=>$list_chats,
            ],
            'nodes'=>['list'=>$nodes],
            'site_blocks'=>[
                'description'=>$blockdesc,
                'basic'=>['list'=>$site_blocks],
                'ai'=>['list'=>$ai_site_blocks],
                'affiliate'=>['list'=>$alft_site_blocks],
            ],
        ];
        if($noelems){
            unset($res['entity_properties']);
            unset($res['group_chats_and_channels']['list']);
            unset($res['messages_best_practices']);
        }
        if(!$noelems){
            $res['funnel_settings']=$funnel_settings;
        }
        if(!$noelems){
            $res['site_blocks']=['default_properties_for_each_block'=>$elem_arch_default]+$res['site_blocks'];
        }
        return $res;
    }
    if($act=='get'){
        $dd=[];
        $id=$ids=$t=$sql=$slg=$select=$rid=$uniq=$res=$count=$asc=$idorder=$sessionid=$slug=$manid=$from=$to=$force=$all='';
        $limit=1000;
        extract($arr);
        $id=($ids?$ids:$id);
        $from=($from?(is_numeric($from)?date('Y-m-d H:i:s',$from):$from):'');
        $to=($to?(is_numeric($to)?date('Y-m-d H:i:s',$to):$to):'');
        $global_label=md5('aihget_'.$t.'_'.$rid.'_'.$slg.'_'.$select.'_'.$uniq.'_'.$idorder.'_'.$asc.'_'.$all.'_'.$asc.'_'.$sessionid.'_'.$slug.'_'.$manid.'_'.$limit.'_'.$from.'_'.$to.'_'.$count.'_'.json_encode($id));
        $time_cond=($from?'time>="'.sql('safe',$from).'"':'').($from&&$to?' AND ':'').($to?'time<="'.sql('safe',$to).'"':'');
        global ${$global_label};
        if(!${$global_label}||$force||$t=='ent'){
            if($all){
                $sql='SELECT * FROM aih_'.$t.' '.($time_cond?'WHERE '.$time_cond:'').' ORDER BY id DESC '.($limit?' LIMIT '.$limit:'');
            }
            if($sessionid||$slug||$manid||$uniq||$slg){
                $attr=[];
                if($sessionid){
                    $attr[]='sessionid='.sql('safe',$sessionid);
                }
                if($slug){
                    $attr[]='slug="'.sql('safe',$slug).'"';
                }
                if($manid){
                    $attr[]='manid='.sql('safe',$manid);
                }
                if($uniq){
                    $attr[]='uniq="'.sql('safe',$uniq).'"';
                }
                if($rid){
                    $attr[]='rid="'.sql('safe',$rid).'"';
                }
                if($slg){
                    $attr[]='slg="'.sql('safe',$slg).'"';
                }
                $attr=implode(' AND ',$attr);
                $sql='SELECT '.($count?'COUNT(*)':'*').' FROM aih_'.$t.' WHERE '.$attr.($time_cond?'AND '.$time_cond:'').' '.(!$asc?'ORDER BY id DESC':'').' '.($limit?' LIMIT '.$limit:'');
            }
            if($id){
                $id=(is_array($id)?$id:explode(',',$id));
                $attr=[];
                foreach ($id as $key=>$value) {
                    $attr[]='id='.sql('safe',$value);
                }
                if(count($attr)==1){
                    $limit=1;
                }
                $attr=implode(' OR ',$attr);
                $sql='SELECT * FROM aih_'.$t.' WHERE '.$attr.($time_cond?'AND '.$time_cond:'').($limit?' LIMIT '.$limit:'');
            }
            if($sql){
                $res=sql_get_data($sql);
            }
            if($res&&is_array($res)){
                foreach ($res as $key=>$value) {
                    if(isset($value['params'])){
                        $prms=json_decode($res[$key]['params'],1);
                        if($t=='message'){
                            $mes_md5=md5($res[$key]['params']);
                            $res[$key]['md5']=$mes_md5;
                            $text=fs($prms,'text');
                            if(is_array($text)){
                                $text=json_encode($text,JSON_UNESCAPED_UNICODE);
                            }
                            $res[$key]['message']=stripslashes($text);
                            $res[$key]['ai_message']=stripslashes($text);
                        }
                        $res[$key]['params']=$prms;
                    }
                }
                if($select){
                    $res=array_combine(array_column($res,'id'),array_column($res,'name'));
                }
            }
            if($res&&$idorder){
                $res=array_combine(array_column($res,'id'),$res);
            }
            if(!$res){
                $res=$dd;
            }
            ${$global_label}=$res;
        } else {
            $res=${$global_label};
        }
        return $res;
    }
    if($act=='octo'){
        $code='';
        extract($arr);
        $code.=html('css','
        .aih_octo_w{max-width:300px;width:100%;margin:0 auto;margin:0 auto 40px;}
        .aih_octo{padding-top:73%;position:relative;}
        .aih_octo>*{position:absolute;width:100%;top:0;}
        .aih_octo>*>*{padding-top:73%;background-repeat:no-repeat;background-size:contain;}

        @keyframes octo_o1_anim{0%{transform:rotate(0deg);}50%{transform:rotate(-5deg);}100%{transform:rotate(0deg);}}
        ');
        $code.='<div class="aih_octo_w"><div class="aih_octo">';
        $code.='<div class="aih_octo_o5"><div style="background-image:url(/crm/base/img/octo/o5.png);transform-origin:32% 40%;animation:octo_o1_anim 3s ease infinite;"></div></div>';
        $code.='<div class="aih_octo_o4"><div style="background-image:url(/crm/base/img/octo/o4.png);transform-origin:61% 36%;animation:octo_o1_anim 2.5s ease infinite;"></div></div>';
        $code.='<div class="aih_octo_o3"><div style="background-image:url(/crm/base/img/octo/o3.png);transform-origin:34% 40%;animation:octo_o1_anim 3.2s ease infinite;"></div></div>';
        $code.='<div class="aih_octo_o2"><div style="background-image:url(/crm/base/img/octo/o2.png);transform-origin: 51% 59%;animation:octo_o1_anim 2.8s ease infinite;"></div></div>';
        $code.='<div class="aih_octo_o1"><div style="background-image:url(/crm/base/img/octo/o1.png);"></div></div>';
        $code.='</div></div>';
        return $code;
    }
    if($act=='create'){
        $slg='';
        $t=$params=[];
        extract($arr);
        $time=date('Y-m-d H:i:s');
        $prms=($params?(is_array($params)?json_encode($params,JSON_UNESCAPED_UNICODE):$params):'');
        if($t=='session'){
            $manid=0;
            extract($arr);
            $rowid=sql_create_row('aih_'.$t,'params,time,manid,slg',$prms,$time,$manid,$slg);
        }
        if($t=='message'){
            $slug=$state=$rid='';
            $type=$sessionid=0;
            extract($arr);
            $rowid=sql_create_row('aih_'.$t,'params,type,time,sessionid,slug,rid,state',$prms,$type,$time,$sessionid,$slug,$rid,$state);
        }
        if($t=='ent'){
            $sessionid=0;
            $slug=$name=$uniq='';
            extract($arr);
            if($uniq){
                $rowid=fs(fs(aih('get',['t'=>'ent','uniq'=>$uniq]),0),'id');
                if($rowid){
                    return $rowid;
                }
            }
            $rowid=sql_create_row('aih_'.$t,'slug,name,params,time,uniq,sessionid',$slug,$name,$prms,$time,$uniq,$sessionid);
        }
        return $rowid;
    }
    if($act=='remove'){
        $id=$t='';
        extract($arr);
        if($t=='session'){
            $messages=aih('get',['t'=>'message','sessionid'=>$id]);
            foreach ($messages as $key=>$value) {
                aih('remove',['t'=>'message','id'=>$value['id']]);
            }
        }
        sql_delete_data_for_js("aih_".$t,"id",sql('safe',$id));
    }
    if($act=='func'){
        extract($arr);
        $ar=[
            /*
            'srategy_create'=>[
                'n'=>__a('Create a sales strategy','Создать стратегию продаж'),
                'public'=>1,
            ],
            'faq_platform'=>[
                'n'=>__a('Answer questions about the platform','Ответить на вопросы по платформе').' MetaFunnels',
                'public'=>1,
            ],
            'script_for_video'=>[
                'n'=>__a('Create a video script','Создать сценарий для видео'),
                'public'=>1,
            ],*/
            'edit_or_create_funnel'=>[
                'n'=>__a('Create and edit a funnel','Создать, отредактировать воронку'),
                'public'=>1,
            ],
        ];
        $ar=['list'=>$ar];
        return $ar;
    }
    if($act=='fake_first_message'){
        $txt=$jfedit=$sessionid='';
        extract($arr);
        $prms=[];
        if($jfedit){
            $jfedit=short_arr($jfedit);
            $fgid=fs($jfedit,'f');
            $stgs_id=fs($jfedit,'s');
            $fg=fs(fg('get',['id'=>$fgid]),0);
            $stgs=jf('stgs',['fgid'=>$fgid]);
            
            $txt.=sr(__a('Hi, I\'m Octo the octopus, I help create sales funnels. It looks like you want to edit or ask a question about the {stage_name} stage in the {funnel_name} funnel. I can help you edit individual elements or answer questions about how this funnel works, node connections, quizzes, and other features you can add to your funnel. Please tell me your request!','Привет, я осьминог Окто, я помогаю создавать воронки продаж. Похоже ты хочешь откредактировать или задать вопрос к этапу {stage_name} воронки {funnel_name}. Я могу помочь тебе с редактированеим отдельных элементов или ответить на вопросы об устройстве этой воронки, связях нодов, квизах и прочих функциях, которые ты можешь установить в свою воронку. Задай, пожалуйста, свой запрос!'),['{funnel_name}','{stage_name}'],['<b>'.fs($fg,'name').'</b>','<b>'.fs(fs($stgs,$stgs_id),'name').'</b>'])."\n";
            $state='funnel_edit_creation';
            $prms['intents']=[[
                'key'=>$state,
                'description'=>sr('User wants to edit or ask a question about the funnel {funnel_name} and probably about the stage {stage_name}',['{funnel_name}','{stage_name}'],['**'.fs($fg,'name').'**','**'.fs(fs($stgs,$stgs_id),'name').'**']),
            ]];
            $prms['fgid']=$fgid;
        } else {
            $txt.=__a('Hi, I’m Octo the octopus, I can help you with the following tasks:','Привет, я осьминог Окто, я могу помочь тебе вот с какими задачами:')."\n";
            $funcs=aih('func');
            $funcs=fs($funcs,'list');
            foreach ($funcs as $key=>$value) {
                $txt.='- '.fs($value,'n')."\n";
            }
            $txt.="\n";
            $txt.=__a('Please describe your request below','Пожалуйста, опиши свой запрос ниже')." 👇\n";
            $state=$default_state;
        }
        $prms['text']=$txt;
        aih('message',['t'=>'create','params'=>$prms,'state'=>$state,'type'=>1,'sessionid'=>$sessionid]);
        return ['text'=>$txt];
    }
    if($act=='message'){
        $type=0;
        $params=[];
        $t=$slug=$noprevconv=$mesid=$rid=$text=$state=$presys=$sessionid='';
        extract($arr);
        if($t=='create'){
            if($rid){
                $message=fs(aih('get',['t'=>'message','sessionid'=>$sessionid,'rid'=>$rid]),0);
                if($message){
                    return ['id'=>fs($message,'id')];
                }
            }
            $text=fs($params,'text');
            $session_count=fs(fs(aih('get',['t'=>'message','count'=>1,'sessionid'=>$sessionid]),0),'COUNT(*)',0);
            if($mesid){
                $mes=fs(aih('get',['t'=>'message','id'=>$mesid]),0);
                foreach ($params as $key=>$value) {
                    sql('set',['id'=>$mesid,'k'=>$key,'v'=>$value,'t'=>'aih_message','prms'=>1]);
                }
            } else {
                $mesid=aih('create',['t'=>'message','rid'=>$rid,'params'=>$params,'slug'=>$slug,'type'=>$type,'sessionid'=>$sessionid,'state'=>$state]);
                sql('set',['id'=>$sessionid,'k'=>'count','v'=>$session_count+1,'t'=>'aih_session','prms'=>1]);
            }
            return ['id'=>$mesid];
        }
        if($t=='phase_add'){
            $text=$slug=$state=$presys=$update=$sessionid='';
            extract($arr);
            if(!$slug){pr('slug is required');bugs();die();}
            $conversation=aih('conversation',['presys'=>$presys,'sessionid'=>$sessionid,'noprevconv'=>$noprevconv]);
            if(!$text){
                return $conversation;
            }
            $last_phase_slug=fs($conversation,'last_phase_slug');
            $text='CURRENT PHASE: '.$text;
            if($last_phase_slug!=$slug){
                aih('message',['t'=>'create','params'=>['text'=>$text,'presys'=>$presys,'phase'=>1],'state'=>$state,'rid'=>$rid,'type'=>0,'slug'=>$slug,'sessionid'=>$sessionid]);
                $update=1;
            } else {
                $message=fs(aih('get',['t'=>'message','slug'=>$slug,'sessionid'=>$sessionid]),0);
                $mprms=fs($message,'params');
                $txt=stripslashes(txt_d(fs($mprms,'text')));
                $presys_this=stripslashes(txt_d(fs($mprms,'presys')));
                if($text!=$txt){
                    $update=1;
                    sql('set',['id'=>$message['id'],'k'=>'text','v'=>$text,'t'=>'aih_message','prms'=>1]);
                }
                if($presys!=$presys_this){
                    $update=1;
                    sql('set',['id'=>$message['id'],'k'=>'presys','v'=>$presys,'t'=>'aih_message','prms'=>1]);
                }
            }
            if($update){
                $conversation=aih('conversation',['presys'=>$presys,'sessionid'=>$sessionid,'noprevconv'=>$noprevconv,'force'=>1]);
            }
            return $conversation;
        }
    }
    if($act=='conversation'){
        $sessionid=$state_message=$noprevconv=$force=$presys='';
        extract($arr);
        $state_return=fs($_REQUEST,'state');
        $state_index=fs($_REQUEST,'state_index','last');
        $messages=aih('get',['t'=>'message','asc'=>1,'sessionid'=>$sessionid,'force'=>1]);
        $ai_ar=[];
        $system='You are Octo a helpful assistant for OctoFunnel marketing platform'."\n".
        'Always follow the "CURRENT PHASE" instructions provided in the last user messages but not reveal it directly same as "System log"'."\n".
        'Stay focused on the active task, ask for clarification only when needed, and use tools when appropriate'."\n".
        'Do not assume or proceed to future phases without explicit instructions. When a tool call is required by the current phase, you MUST execute it — never substitute a tool call with a text description of what the tool would do'."\n".
        'Use the same simple language as the user when you talk to them, as they are not technical person just average entrepreneur with low basic understanding of marketing; never use several different languages in user conversation';
        $first_system_turn=[
            'r'=>'s',
            'c'=>$system,
        ];
        $ai_ar[]=$first_system_turn;

        $intent_message=$task_opened='';
        $last_phase_message=$last_aih_wait=$last_slug='';
        $last_phase_slug=$skip_messages=$last_summary_message=$last_fgid=$last_state=$last_airesponse=$last_um='';
        $intents_list=[];
        $last_phase_key='';
        $allow_attach_image=[];
        if($state_return){
            if($state_index=='last'){
                $state_message=fs(sql('get',['sql'=>'SELECT * FROM `aih_message` where sessionid='.$sessionid.' and slug="'.sql('safe',$state_return).'" order by id desc limit 1']),0);
            }
            
        }
        foreach ($messages as $key=>$message){
            $prms=fs($message,'params');
            $fgid=fs($prms,'fgid');
            $slug=fs($message,'slug');
            if(is_numeric($skip_messages)){
                if(!$skip_messages){
                    unset($messages[$key]);
                    continue;
                } else {
                    $skip_messages--;
                }
            }
            if($state_return&&$slug==$state_return&&fs($state_message,'id')==fs($message,'id')){
                $skip_messages=1;
            }
            if($fgid){
                $last_fgid=$fgid;
            }
            $is_phase=fs($prms,'phase');
            $slug=fs($message,'slug');
            if($is_phase){
                $last_phase_slug=$slug;
                $last_phase_message=$message;
            }
            $type=fs($message,'type',0);
            //set up roles
            $role=($type?'a':'u');
            $messages[$key]['role']=$role;
            //set up remebering images
            if($role=='u'&&!$is_phase){
                $last_um=$message;
                $allow_attach_image=$message;
            }
            if($role=='a'){
                $allow_attach_image='';
            }
            //set up task context
            $taskid=fs($prms,'taskid');
            $taskclose=fs($prms,'taskclose');
            if($taskid&&!$taskclose){
                $task_opened=$message;
            }
        }

        //shorten context
        $summary_every_n_messages=5;
        $context_length=15;
        $messages=array_reverse($messages);
        $count=0;
        $messages_to_summarize=[];
        $summary_messages_count=0;
        $summary_messages_count_max=2;
        foreach ($messages as $key=>$message){
            $mes_prms=fs($message,'params');
            $is_phase=fs($mes_prms,'phase');
            if($is_phase){
                continue;
            }
            if($count<$context_length){

            } else {
                $has_summary=fs($mes_prms,'summary');
                if(!$has_summary&&!$last_summary_message||$has_summary&&$last_summary_message&&$summary_messages_count<$summary_messages_count_max){
                    $messages_to_summarize[]=$message;
                    if($has_summary){
                        $summary_messages_count++;
                    }
                } else {
                    if(!$last_summary_message){
                        $last_summary_message=$message;
                    }
                }
            }
            $count++;
        }
        $messages=array_reverse($messages);
        if(count($messages_to_summarize)-$summary_messages_count_max>$summary_every_n_messages){
            $messages_to_summarize=array_reverse($messages_to_summarize);
            $sprompt="Summarize the following conversation chunk concisely, capturing key points, decisions, and context without losing important details. Dont add any text formatting. Keep it brief and objective:\n\n";
            foreach ($messages_to_summarize as $key=>$message){
                $type=fs($message,'type');
                $prms=fs($message,'params');
                $summary=fs($prms,'summary');
                $type=fs($message,'type');
                if($summary){
                    $sprompt.='Summary: '.$summary."\n\n";
                } else if($type=='user'){
                    $sprompt.='User: '.fs($message,'message')."\n\n";
                } else {
                    $sprompt.='Assistant: '.fs($message,'ai_message')."\n\n";
                }
            }
            $r=ai('send',[
                'model'=>'groks',
                'messages'=>[
                    ['r'=>'s','c'=>$sprompt],
                    ['r'=>'u','c'=>'Use language of the user'],
                ]
            ]);

            $summary=fs($r,'content');
            sql('set',['id'=>fs($message,'id'),'k'=>'summary','v'=>$summary,'t'=>'aih_message','prms'=>1]);
        }
        




        foreach ($messages as $key=>$message){
            $prms=fs($message,'params');
            $slug=fs($message,'slug');
            $is_phase=fs($prms,'phase');
            $state=fs($message,'state');
            $aih_wait=fs($prms,'aih_wait');
            $aih_wait_done=fs($prms,'aih_wait_done');
            
            if($aih_wait){
                if($aih_wait_done||fs($messages,$key+1)){
                    $aih_wait['done']=1;
                }
                $last_aih_wait=$aih_wait;
            }
            $last_state=$state;
            $log=fs($prms,'log');
            $slug=fs($message,'slug');
            if($slug){
                $last_slug=$slug;
            }
            $ai_result=fs($prms,'ai_result');
            if($ai_result){
                $last_airesponse=$message;
            }
            
            $summary=fs($prms,'summary');
            $ai_message=fs($message,'ai_message');
            if($log){
                $ai_message.='[System log: '.$log.'; Get user to the next step]';
            }
            $media_ids=fs($prms,'media_ids');
            $media_ids=($media_ids?explode(',',$media_ids):[]);
            $role=fs($message,'role');
            $intents=fs($prms,'intents');
            if($intents){
                $intent_message=$message;
                $intents_list=$intents;
            }
            $data=[
                'r'=>$role,
                'c'=>stripslashes($ai_message),
            ];
            if($media_ids){
                $allow_to_see=fs($allow_attach_image,'id')==fs($message,'id');
                $ai_message.="\n".'[User attached file ID'.(count($media_ids)>1?'\'s':'').': '.implode(',',$media_ids).']';
                
                $medias=media('get',['ids'=>$media_ids]);
                $media_data=[];
                $image_medias=[];
                foreach($medias as $media){
                    $media_id=fs($media,'id');
                    $media_prms=fs($media,'params');
                    $mime=fs($media_prms,'mime');
                    $mime_type=fs(explode('/',$mime),0);
                    $ext=strtolower(pathinfo(fs($media,'url'), PATHINFO_EXTENSION));
                    $word_exts=['doc','docx'];
                    $is_word=in_array($ext,$word_exts);
                    if(strp('/pdf',$mime)){
                        $filename=basename($path.fs($media,'url'));
                        $pdf_text=rare('pdf2text',['filepath'=>$path.fs($media,'url'),'mediaid'=>$media_id]);
                        $ai_message.='<attached_pdf id="'.$media_id.'" name="'.$filename.'">'.$pdf_text.'</attached_pdf>';
                    }
                    if($mime=='text/plain'||$mime=='text/html'||$mime=='application/json'){
                        $filename=basename($path.fs($media,'url'));
                        $file_text=file_get_contents($path.fs($media,'url'));
                        $ai_message.='<attached_file id="'.$media_id.'" name="'.$filename.'">'.$file_text.'</attached_file>';
                    }
                    if($is_word){
                        $filename=basename($path.fs($media,'url'));
                        $doc_text=rare('word2text',['filepath'=>$path.fs($media,'url'),'mediaid'=>$media_id]);
                        $ai_message.='<attached_doc id="'.$media_id.'" name="'.$filename.'">'.$doc_text.'</attached_doc>';
                    }
                    if($mime_type=='image'){
                        if($allow_to_see){
                            $media_data[]=fs($media,'1024');
                        } else {
                            $image_medias[]=$media_id;
                        }
                    }
                }
                if($media_data){
                    $data['img']=$media_data;
                } else {
                    $ai_message.='[System: image'.(count($image_medias)>1?'s are ':'is ').(implode(',',$image_medias)).' hidden to save tokens, ask to resend if need additional look]';
                }
            }
            $data['c']=stripslashes($ai_message);
            if($is_phase&&!$presys){
                $data['cache']=1;//for Claude
            }
            $allow_to_add=1;
            if(!$ai_message){
                $allow_to_add=0;
            }
            //CURRENT PHASE
            if($last_summary_message){
                if(fs($last_summary_message,'id')==fs($message,'id')){
                    $ai_ar=[];
                    $ai_ar[]=$first_system_turn;
                    $ai_ar[]=['r'=>'u','c'=>fs(fs($intents_list,0),'description') ];
                    $data['r']='a';
                    $data['c']='Summary: '.$summary;
                } else if(fs($last_summary_message,'id')>fs($message,'id')) {
                    $allow_to_add=0;
                    $log='';
                }
            }
            if($task_opened){
                if(fs($task_opened,'id')==fs($message,'id')){
                    $ai_ar=[];
                    $ai_ar[]=$first_system_turn;
                    $ai_ar[]=['r'=>'u','c'=>fs(fs($intents_list,0),'description') ];
                } else if(fs($task_opened,'id')>fs($message,'id')){
                    $allow_to_add=0;
                    $log='';
                }
            }
            if($noprevconv){
                if(fs($last_phase_message,'id')==fs($message,'id')){
                    $ai_ar=[];
                    $ai_ar[]=$first_system_turn;
                } else if(fs($last_phase_message,'id')>fs($message,'id')){
                    $allow_to_add=0;
                    $log='';
                }
            }

            if($allow_to_add){
                $ai_ar[]=$data;
            }
            if($log){
                $ai_ar[]=[
                    'r'=>'u',
                    'c'=>'OK',
                ];
            }
        }
        $ai_ar=array_filter($ai_ar);
        //remove CURRENT PHASE: not last
        $last_phase_found=0;
        foreach (array_reverse($ai_ar,1) as $key=>$value) {
            if(strp('CURRENT PHASE:',fs($value,'c'))){
                if($last_phase_found&&$key!=(count($ai_ar)-1)){
                    unset($ai_ar[$key]);
                } else {
                    $last_phase_found=1;
                }
            }
        }
        if($presys){
            foreach($ai_ar as $key=>$ai_ar_item){
                if(strp('CURRENT PHASE:',fs($ai_ar_item,'c'))){
                    array_splice($ai_ar, $key , 0, [
                        ['r'=>'u', 'c'=>$presys, 'cache'=>1]
                    ]);
                    break;
                }
            }
        }
        $ai_ar=array_filter($ai_ar);
        
        return [
            'messages'=>$messages,
            'ar'=>$ai_ar,
            'last_slug'=>$last_slug,
            'last_state'=>$last_state,
            'last_user_message'=>$last_um,
            'last_airesponse'=>$last_airesponse,
            'intents_list'=>$intents_list,
            'last_fgid'=>$last_fgid,
            'last_aih_wait'=>$last_aih_wait,
            'task_opened'=>$task_opened,
            'intent_message'=>$intent_message,
            'current_intent'=>fs(fs($intents_list,0),'key'),
            'last_phase_slug'=>$last_phase_slug
        ];
    }
    if($act=='ents'){
        $ar=[
            'fg'=>[
                'n'=>'Funnel',
                'slug'=>'funnel',
                'd'=>'Funnel is a collection of pages and actions that are used to create a sales funnel',
            ],
            'profile'=>[
                'n'=>'Profile',
                'slug'=>'profile',
                'd'=>'A profile is an entity that stores valuable information for creating a comprehensive funnel content about your business, products, or services. This includes all the knowledge that your clients need to know about your product and different aspects of your service to have an effective funnel content',
            ],
            'strategy'=>[
                'n'=>'Strategy',
                'slug'=>'strategy',
                'd'=>'A strategy is a plan of sales for a product which AI uses to create funnel itself: messages, actions, pages, etc',
            ],
        ];
        return $ar;
    }
    if($act=='select_ent_help'){
        $sys='';
        $tools=[];
        $select=[];
        $n='';
        extract($arr);
        $functions_to_use=[];
        $actions=fs($arr,'actions',[]);
        foreach($actions as $key=>$action){
            if($key=='create'||$key=='select'){
                $functions_to_use[]=$action['n'];
            }
            $tools[]=[
                'type'=>'function',
                'function'=>[
                    'name'=>$action['n'],
                    'description'=>$action['d'],
                    'strict'=>true,
                    'parameters'=>[
                        'type'=>'object',
                        'properties'=>$action['properties'],
                        'required'=>$action['required'],
                        'additionalProperties'=>false,
                    ],
                ],
            ];
        }

        $ents=aih('ents');
        $ent_obj=fs($ents,$ent);
        $sys='To process clients requests further we need to make this step done'."\n";
        $sys.='Current process: '.$n."\n";
        $sys.='Entity: '.fs($ent_obj,'n').' - '.fs($ent_obj,'d')."\n";
        if($select){
            $select_ar=[];
            foreach($select as $key=>$select){
                $select_ar[]=$select.' (ID: '.$key.')';
            }
            $sys.='Tell what we need to do and why this entity is needed'."\n";
            $sys.='Entities to select (names only for user, but you know IDs): '.implode(',',$select_ar)."\n";
            $sys.='Present existing options to the user in a formatted list (e.g., - EntityName1\n- EntityName2), without IDs.'."\n";
            $sys.='Ask the user to select an existing entity by name or provide a new name to create one.'."\n";
            $sys.='If creating new and the name already exists, suggest a slight variation (e.g., append _2) and ask for confirmation or new name.'."\n";
        } else {
            $sys.='As the user doesn\'t have any entity to select, ask they to create a new one'."\n";
            $sys.='Ask the user to provide a new name for the entity.'."\n";
        }
        
        $sys.='Once the choice is clear and valid (no conflicts), use the "'.implode('" OR "',$functions_to_use).'" tool to confirm.'."\n";
        $sys.='This may take multiple turns; keep asking until ready to call the tool.'."\n";
        $sys.='Users interact only by entity names; you must map existing names to their IDs internally when selecting.'."\n";
        $remove_action=fs($actions,'remove');
        if($remove_action){
            $sys.=(fs($remove_action,'hidden')?'Don\'t mention it but ':'').'If the user expresses intent to delete an entity (e.g., using words like "delete", "remove", "erase", or similar in any language, and mentioning an entity name), detect the intent regardless of exact phrasing or case, confirm the name matches an existing one (case-insensitive), map to ID, and use the "'.fs(fs($actions,'remove'),'n').'" tool to confirm'."\n";
        }
        return ['sys'=>$sys,'tools'=>$tools];
    }
    if($act=='state'){
        $sys='';
        $hidden_slug_prefix=$hidden_slug_suffix=$reasoning_effort=$thinking='';
        $states=$presys=$noslug=$noprevconv=$response_format=$data_fast=$noanswer=$run_again=$rid=$aimes=$ai_json=$ai_arr=$result=$messages=$tools=$filter=[];
        $slug='';
        $tool=[];
        $model='grokst';
        extract($arr);
        if(!fs($_REQUEST,'test')&&!platform()){
            global $pr_silence;
            $pr_silence=1;
        }
        j('state---------------','ggg');
        j(bugs(1),'ggg');
        $tool_choice='auto';
        $tools=[];
        if(!$noslug){
            $conversation=aih('conversation',['sessionid'=>$sessionid]);
            $last_um=fs($conversation,'last_user_message');
            $last_state=fs($conversation,'last_state');
            $messages=fs($conversation,'messages',[]);
            $last_message=fs($messages,array_key_last($messages));
            $last_slug=fs($conversation,'last_slug');
            $slug=($slug?$slug:$last_state);
        }

        if($noslug){
            $slug='';
        }
        if($slug&&fs($_REQUEST,'test')){
            pr('slug:'.$slug);
        }




        
        //------------------------------------------------------------------------------------
        $state='intention_detect';
        $states[$state]=[
            ''=>'',
        ];
        if($slug=='intention_detect'){
            $model='grokst';
            $sys.='Please detect intention';
            $sys='';
            $sys.='Please analyze the client’s messages. If the intent is complete and clearly defined, use the "categorize_intents" tool'."\n";
            $sys.='If the intent is not clear, ask clarifying questions to clarify the task'."\n";
            $sys.='Please analyze the client’s messages to identify their intents'."\n";
            $sys.='Available intents: '."\n";
            $available_intents=fs(aih('state',['noslug'=>1,'filter'=>['visible_on_init']]),'states',[]);
            foreach($available_intents as $key=>$intent){
                $sys.='- '.$key.' - '.fs($intent,'n')."\n";
            }
            $sys.='If the intent is complete and clearly defined, use the "categorize_intents" tool to categorize them, providing for each a key from the available intents and a description formulated as the user expressed it, from the user\'s point of view, without losing any details. Order the intents logically in the array, prioritizing quicker tasks (e.g., question_answering) before time-consuming ones (e.g., funnel_creation_editing).'."\n";
            $sys.='If the intent is not clear, ask clarifying questions to clarify the task.';

            $tools[]=[
                'type'=>'function',
                'function'=>[
                    'name'=>'categorize_intents',
                    'description'=>'Categorize the user\'s clear intents using the specified format. Only call this when intents are fully understood',
                    'strict'=>true,
                    'parameters'=>[
                        'type'=>'object',
                        'properties'=>[
                            'intents'=>[
                                'type'=>'array',
                                'description'=>'Array of intents with keys and descriptions, in execution order',
                                'items'=>[
                                    'type'=>'object',
                                    'properties'=>[
                                        'key'=>[
                                            'type'=>'string',
                                            'enum'=>array_keys($available_intents),
                                            'description'=>'The key of the intent',
                                        ],
                                        'description'=>[
                                            'type'=>'string',
                                            'description'=>'Description of the intent as formulated by the user, from their point of view, preserving all details',
                                        ],
                                    ],
                                    'required'=>['key','description'],
                                    'additionalProperties'=>false,
                                ],
                            ],
                        ],
                        'required'=>['intents'],
                        'additionalProperties'=>false,
                    ],
                ]
            ];
            if($result){
                $tool_calls=fs($result,'tool_calls',[]);
                if($tool_calls){
                    foreach ($tool_calls as $key=>$tool_call){
                        $function=fs($tool_call,'function');
                        $function_name=fs($function,'name');
                        $arguments=fs($function,'arguments',[]);
                        $arguments=json_repair($arguments);
                        $intents=fs($arguments,"intents",[]);
                        if(is_array($intents)){
                            $new_state=fs(fs($intents,0),'key');
                            sql("set",["id"=>fs($last_um,"id"),"k"=>"intents","v"=>$intents,"t"=>"aih_message","prms"=>1]);
                            sql("set",["id"=>fs($aimes,"id"),"k"=>"state","v"=>$new_state,"t"=>"aih_message"]);
                            $run_again=1;
                        }
                    }
                    //bot('alert',['text'=>'AI RESPONSE: got tool calls']);
                }
            }
        }
        //------------------------------------------------------------------------------------
        //edit
        $state='funnel_edit_creation';
        $states[$state]=[
            'n'=>'When a user wants to edit existing or create a new funnel',
            'visible_on_init'=>1,
        ];
        if($slug=='funnel_edit_creation'){
            $state_return=fs($_REQUEST,'state');
            $temp_vars=aih('temp_vars',['sessionid'=>$sessionid,'require'=>['fgid','profileid','variables_to_use','taskid']]);
            $fgid=fs($temp_vars,'fgid');
            $data_fast=['fgid'=>$fgid];
            $fg=fs(fg('get',['id'=>$fgid]),0);
            $fg_prms=fs($fg,'params',[]);
            $aih_profile=fs($fg_prms,'aih_profile');
            

            if(!$fgid){
                return ['slug'=>$state]+aih('state',['slug'=>'funnel_select']+$arr);
            }
            $profileid=fs($temp_vars,'profileid');
            if($aih_profile){
                $profileid=$aih_profile;
            }
            if(!$profileid){
                return ['slug'=>$state]+aih('state',['slug'=>'profile_select']+$arr);
            }
            $profile=fs(aih('get',['t'=>'ent','id'=>$profileid]),0);
            if(!$profile){ //fallback again
                if($aih_profile){
                    sql("set",['id'=>$fgid,'k'=>'aih_profile','remove'=>1,'t'=>'func_group','prms'=>1]);
                }
                return ['slug'=>$state]+aih('state',['slug'=>'profile_select']+$arr);
            }
            $profile_prms=fs($profile,'params',[]);
            $full_filled=fs($profile_prms,'full_filled');
            if($profileid&&!$full_filled){
                return ['slug'=>$state]+aih('state',['slug'=>'profile_fill']+$arr);
            }
            $aih_strategy=fs($fg_prms,'aih_strategy');
            
            $strategyid=$aih_strategy;
            $strategy=fs(aih('get',['t'=>'ent','id'=>$aih_strategy]),0);
            $strategy_prms=fs($strategy,'params',[]);
            if(!$aih_profile){
                sql("set",["id"=>$fgid,"k"=>"aih_profile","v"=>$profileid,"t"=>"func_group","prms"=>1]);
            }
            
            $strategy_full_filled=fs($strategy_prms,'content');
            if(!$strategy_full_filled){
                return ['slug'=>$state]+aih('state',['slug'=>'strategy_build']+$arr);
            }
            $taskid=fs($temp_vars,'taskid');
            if(!$taskid){
                return ['slug'=>$state]+aih('state',['slug'=>'task_get','data_fast'=>$data_fast]+$arr);
            }
            $task=fs(aih('get',['t'=>'ent','id'=>$taskid]),0);
            $task_prms=fs($task,'params',[]);
            $is_new_funnel=fs($task_prms,'new_funnel');
            $stages=fs($task_prms,'stages');
            $task_vrs=fs($task_prms,'vrs');
            $data_fast=$data_fast+[
                'fg'=>$fg,
                'taskid'=>$taskid,
                'task'=>$task,
                'strategyid'=>$aih_strategy,
                'strategy'=>$strategy,
                'profileid'=>$profileid,
                'profile'=>$profile,
                'new_funnel'=>$is_new_funnel,
            ];
            $need_questions=fs($task_prms,'need_questions');
            if(!$need_questions&&$is_new_funnel){
                return ['slug'=>$state]+aih('state',['slug'=>'need_questions','data_fast'=>$data_fast]+$arr);
            }
            /*
            if(!$stages){
                return ['slug'=>$state]+aih('state',['slug'=>'stage_divider','data_fast'=>$data_fast]+$arr);
            }*/
            $visual_pref=fs($strategy_prms,'visual_pref');
            $media_get=fs($strategy_prms,'media_get');
            $use_images=fs($task_prms,'use_images');
            //zzz
            //pr($task_prms);
            //get media
            if($is_new_funnel){
                if($use_images){
                    if(!$visual_pref){
                        return ['slug'=>$state]+aih('state',['slug'=>'visual_pref_get','data_fast'=>$data_fast]+$arr);
                    }
                    if(!$media_get){
                        return ['slug'=>$state]+aih('state',['slug'=>'media_get','data_fast'=>$data_fast]+$arr);
                    }
                }
                $sync_branding=fs($task_prms,'sync_branding');
                $synced_branding=fs($task_prms,'synced_branding');
                if($visual_pref&&$sync_branding&&!$synced_branding){
                    aih('sync_branding',['fgid'=>$fgid,'taskid'=>$taskid,'profile'=>$profile,'visual_pref'=>$visual_pref]);
                }

                $strategy_content=fs($strategy_prms,'content');
                foreach ($strategy_content as $key=>$value){
                    if(!fs($task_prms,'stage_done_'.$key)||$state_return=='fill_'.$key){
                        return ['slug'=>$state]+aih('state',['slug'=>'fill','stage_index'=>$key,'data_fast'=>$data_fast]+$arr);
                    }
                }
            }else{
                $task_content=fs($task_prms,'content');
                $update_media=fs($task_content,'update_media');
                $updated_media=fs($task_prms,'updated_media');
                if($update_media&&!$updated_media){
                    return ['slug'=>$state]+aih('state',['slug'=>'media_get','update_media'=>1,'data_fast'=>$data_fast]+$arr);
                }
                $edits=fs($task_content,'edits',[]);
                foreach ($edits as $key => $value) {
                    if(!fs($task_prms,'edit_done_'.$key)||$state_return=='fill_'.$key){
                        return ['slug'=>$state]+aih('state',['slug'=>'fill','edit_index'=>$key,'data_fast'=>$data_fast]+$arr);
                    }
                }
            }
            //finish
            return ['slug'=>$state]+aih('state',['slug'=>'finish','data_fast'=>$data_fast]+$arr);



            
            //bot('alert',['text'=>'Profile is full filled']);
            //die('here!');
        }
        //------------------------------------------------------------------------------------
        $state='funnel_select';
        $states[$state]=[];
        if($slug=='funnel_select'){
            $model='grokst';
            $fgs=fg('get',['type'=>20,'idorder'=>1,'stgsui'=>1,'select'=>1]);
            $last_fgid=fs($conversation,'last_fgid');

            $select_ent_help=aih('select_ent_help',[
                'n'=>'Select funnel to edit',
                'ent'=>'fg',
                'select'=>$fgs,
                'actions'=>[
                    'create'=>['n'=>'funnel_create','d'=>'Create a new funnel','properties'=>['new_funnel_name'=>['type'=>'string','description'=>'Name of the new funnel']],'required'=>['new_funnel_name']],
                    'remove'=>['n'=>'funnel_remove','d'=>'Remove an existing funnel','properties'=>['funnel_id'=>['type'=>'integer','description'=>'ID of the funnel to remove']],'required'=>['funnel_id']],
                    'select'=>['n'=>'funnel_select','d'=>'Select an existing funnel','properties'=>['funnel_id'=>['type'=>'integer','description'=>'ID of the funnel to select']],'required'=>['funnel_id']],
                ],
            ]);

            //$last_fgid
            $sys=fs($select_ent_help,'sys');
            if($last_fgid&&fs($fgs,$last_fgid)){
                $sys.='From the context of last conversation, more likely, user wants to edit funnel "'.fs($fgs,$last_fgid).'". ID:'.$last_fgid.' Mention this in your response and mark name bold'."\n";
            }
            $tools=fs($select_ent_help,'tools');
            if($result){
                $tool_calls=fs($result,'tool_calls',[]);
                if($tool_calls){
                    foreach ($tool_calls as $key=>$tool_call){
                        $function=fs($tool_call,'function');
                        $function_name=fs($function,'name');
                        $arguments=fs($function,'arguments',[]);
                        if($function_name=='funnel_create'){
                            $new_funnel_name=fs($arguments,'new_funnel_name');
                            $fgid=jf("new",["name"=>$new_funnel_name,"uniq"=>1,'from_aih'=>1]);
                            $log='Funnel was created';
                            sql("set",["id"=>fs($last_um,"id"),"k"=>"fgid","v"=>$fgid,"t"=>"aih_message","prms"=>1]);
                            sql("set",["id"=>$fgid,"k"=>"aih_created","v"=>$sessionid,"t"=>"func_group","prms"=>1]);
                        }
                        if($function_name=='funnel_remove'){
                            $funnel_id=fs($arguments,'funnel_id');
                            jf("remove_path",["fgid"=>$funnel_id]);
                            $log='Funnel was removed, now please back user to selecting or creating a funnel';
                        }
                        if($function_name=='funnel_select'){
                            $funnel_id=fs($arguments,'funnel_id');
                            sql("set",["id"=>fs($last_um,"id"),"k"=>"fgid","v"=>$funnel_id,"t"=>"aih_message","prms"=>1]);
                            $log='Funnel was selected';
                        }
                        if($log){
                            $run_again=1;
                            sql("set",["id"=>fs($aimes,"id"),"k"=>'log',"v"=>$log,"t"=>"aih_message",'prms'=>1]);
                        }
                    }
                }
            }
        }
        //------------------------------------------------------------------------------------
        $state='profile_select';
        $states[$state]=[];
        if($slug=='profile_select'){
            $model='grokst';
            $profiles=aih('get',['t'=>'ent','slug'=>'profile','select'=>1]);
            $select_ent_help=aih('select_ent_help',[
                'n'=>'Select profile to edit',
                'ent'=>'profile',
                'select'=>$profiles,
                'actions'=>[
                    'create'=>['n'=>'profile_create','d'=>'Create a new profile','properties'=>['new_profile_name'=>['type'=>'string','description'=>'Name of the new profile']],'required'=>['new_profile_name']],
                    'remove'=>['n'=>'profile_remove','d'=>'Remove an existing profile','properties'=>['profile_id'=>['type'=>'integer','description'=>'ID of the profile to remove']],'required'=>['profile_id']],
                    'select'=>['n'=>'profile_select','d'=>'Select an existing profile','properties'=>['profile_id'=>['type'=>'integer','description'=>'ID of the profile to select']],'required'=>['profile_id']],
                ],
            ]);
            $sys=fs($select_ent_help,'sys');
            $tools=fs($select_ent_help,'tools');
            if($result){
                $tool_calls=fs($result,'tool_calls',[]);
                if($tool_calls){
                    foreach ($tool_calls as $key=>$tool_call){
                        $function=fs($tool_call,'function');
                        $function_name=fs($function,'name');
                        $arguments=fs($function,'arguments',[]);
                        if($function_name=='profile_create'){
                            $new_profile_name=fs($arguments,'new_profile_name');
                            $log='Profile was created';
                            $pid=aih("create",["t"=>"ent","name"=>$new_profile_name,"uniq"=>$new_profile_name,"slug"=>"profile"]);
                            sql("set",["id"=>fs($last_um,"id"),"k"=>"profileid","v"=>$pid,"t"=>"aih_message","prms"=>1]);
                        }
                        if($function_name=='profile_remove'){
                            $profile_id=fs($arguments,'profile_id');
                            $log='Profile was removed, now please back user to selecting or creating a profile';
                            aih("remove",["t"=>"ent","id"=>$profile_id]);
                        }
                        if($function_name=='profile_select'){
                            $profile_id=fs($arguments,'profile_id');
                            $log='Profile was selected';
                            sql("set",["id"=>fs($last_um,"id"),"k"=>"profileid","v"=>$profile_id,"t"=>"aih_message","prms"=>1]);
                        }
                        if($log){
                            $run_again=1;
                            sql("set",["id"=>fs($aimes,"id"),"k"=>'log',"v"=>$log,"t"=>"aih_message",'prms'=>1]);
                        }
                    }
                }
            }
        }
        //------------------------------------------------------------------------------------
        $state='profile_fill';
        $states[$state]=[];
        if($slug=='profile_fill'){
            $temp_vars=aih('temp_vars',['sessionid'=>$sessionid,'require'=>['profileid','profile_20_answered']]);
            $profileid=fs($temp_vars,'profileid');
            $profile_20_answered=fs($temp_vars,'profile_20_answered');
            $profile=fs(aih('get',['t'=>'ent','id'=>$profileid]),0);
            $profile_prms=fs($profile,'params');
            $full_filled=fs($profile_prms,'full_filled');
            if(!$profile_20_answered){
                $sys='';
                $sys.='Your goal is to gather the richest, most detailed information possible about the user\'s business so that a high-converting sales funnel can be built from it. The quality of the funnel depends entirely on the depth and specificity of what you collect here.'."\n";
                $sys.='In the first turn of the conversation, ask only these three high-level questions: What do you sell? Who do you sell to? What pain or problem of your clients does your product or service solve? Do not ask any other questions in this first turn. Be warm and encouraging.'."\n";
                $sys.='In the second turn, after the user responds, generate 20 targeted questions based specifically on their niche, product, and audience. The questions must be tailored — do not use generic questions that could apply to any business. Before writing the questions, internally identify: what type of business this is, who the buyer is, what the core transformation or result is, and what the most likely sales objections are. Then craft questions to extract the following funnel-critical categories:'."\n";
                $sys.='- OFFER: Exact pricing, payment options, entry points, tiers, bonuses, guarantees, trial periods, what is included and excluded.'."\n";
                $sys.='- TRANSFORMATION: The specific before/after state of the client — where they are now, where they end up, in concrete measurable terms.'."\n";
                $sys.='- PROOF: Real case studies with specific numbers, names, timeframes. Testimonials with exact quotes. Personal founder results. Platform or product-level aggregate results.'."\n";
                $sys.='- OBJECTIONS: The most common reasons people hesitate to buy, and how those objections are overcome. What makes people say "not now" or "not for me".'."\n";
                $sys.='- EMOTIONS: What does the client feel before they find this product (frustration, fear, shame, stuck)? What do they feel after? What do they secretly want beyond the practical outcome?'."\n";
                $sys.='- COMPETITION: Who else solves this problem? Why is this product better, different, or uniquely suited for this audience?'."\n";
                $sys.='- TRUST: What builds credibility — experience, story, credentials, community size, track record, media, partnerships?'."\n";
                $sys.='- SALES PROCESS: How do clients typically find this product, how do they make the decision, how long does it take, who else is involved in the decision?'."\n";
                $sys.='- PRODUCT MECHANICS: How does it actually work step by step? What does the client do on day 1, week 1, month 1?'."\n";
                $sys.='- AUDIENCE SPECIFICS: Demographics, behaviors, where they spend time online, what content they consume, what they have tried before that failed.'."\n";
                $sys.='Present all 20 questions in a numbered list. Tell the user: these questions are designed to extract the details that will make your funnel actually convert. Answer as richly as possible — write as much as you want, the more detail the better. You can answer in any order, in groups, or all at once across multiple messages. Feel free to share anything beyond these questions too.'."\n";
                $sys.='In the third turn, after the user answers, do not repeat unanswered questions. Instead, review what was provided and identify: (1) any funnel-critical categories from above that are still vague or missing, (2) any specific claims that need concrete numbers or examples to be usable, (3) any emotional or story elements that are underdeveloped. Generate up to 10 new targeted questions that specifically address these gaps. Frame them as helping make the funnel stronger, not as an interrogation. Present them in a numbered list.'."\n";
                $sys.='In subsequent turns, if new answers reveal further gaps, ask up to 3-5 focused clarifying questions. Always prioritize depth over breadth at this stage.'."\n";
                $sys.='When evaluating whether enough information has been gathered, check holistically: Is the offer clearly defined with real pricing? Is the transformation specific and measurable? Is there at least one concrete proof point (case study, result, testimonial)? Is the target audience identifiable? If yes to all of these, the information is sufficient even if some secondary questions were skipped. If the user explicitly says they are done, respect that and proceed. Do not demand perfection — a rich incomplete picture is better than a shallow complete one.'."\n";
                $sys.='Once sufficient information is gathered, call the "profile_save_and_go_next" tool. Do not call it earlier.'."\n";
                $sys.='If the user provides minimal information overall, still proceed after one gentle prompt for more depth — do not block them.'."\n";
                
                $tools[]=[
                    'type'=>'function',
                    'function'=>[
                        'name'=>'profile_save_and_go_next',
                        'description'=>'Call this step when a user is ready to go further after providing the information',
                        'parameters'=>[
                            'type'=>'object',
                            'required'=>[],
                            'additionalProperties'=>false,
                        ],
                    ],
                ];
                if($result){
                    $tool_calls=fs($result,'tool_calls',[]);
                    if($tool_calls){
                        foreach ($tool_calls as $key=>$tool_call){
                            $function=fs($tool_call,'function');
                            $function_name=fs($function,'name');
                            $arguments=fs($function,'arguments',[]);
                            $run_again=1;
                            sql("set",["id"=>fs($aimes,"id"),"k"=>"profile_20_answered","v"=>1,"t"=>"aih_message","prms"=>1]);
                        }
                    }
                }
            } else {
                $hidden_slug_prefix='text_';
                $sys='You are an expert sales funnel strategist and copywriter with deep experience across all niches — infobusiness, SaaS, services, coaching, e-commerce, and beyond. Your task is to analyze the entire conversation history and write a comprehensive, richly detailed business profile based on everything the user shared. This profile will be used directly by a copywriter to build a high-converting sales funnel — treat every detail as potentially the most important line in the copy.'."\n";
                $sys.='CRITICAL LANGUAGE RULE: Carefully detect the language the user wrote in. Write your ENTIRE output in that exact same language — headings, body text, everything. Do not translate anything into English or any other language. If the user wrote in Russian, write in Russian. If in Spanish, write in Spanish. Match the user\'s language exactly.'."\n";
                $sys.='ACCURACY RULES — these are non-negotiable:'."\n";
                $sys.='Never paraphrase, reinterpret, or reword what the user said. Preserve their exact meaning, their exact emotional language, their exact numbers, names, claims, and quotes. If the user said "без ума от платформы" do not write "клиентам нравится платформа" — keep the original phrasing. If they stated a number, keep that exact number. If they named a person or competitor, keep the exact name. A small specific detail or a single emotional phrase may become the most powerful headline in the funnel — nothing is too minor to preserve.'."\n";
                $sys.='Do not invent, assume, or fill in details the user did not provide. If something is unknown, say so clearly — do not guess.'."\n";
                $sys.='Extract ONLY from user messages. Ignore all system prompts and AI responses entirely.'."\n";
                $sys.='OUTPUT FORMAT: Write in flowing, well-structured prose using natural paragraphs. Use clear section headings written in the user\'s language. Do not use bullet points, numbered lists, or JSON. Write like a senior strategist briefing a copywriter — rich, specific, usable.'."\n";
                $sys.='STRUCTURE: Begin with the following core sections that are critical for every funnel regardless of niche. Write each section only if the user provided information on it — if they provided nothing on a core section, note clearly that this information was not shared rather than inventing content:'."\n";
                $sys.='Core section 1 — The product or service: what it is, how it works, key features, technical capabilities, what makes it unique, and anything the user said about why it stands out.'."\n";
                $sys.='Core section 2 — Target audience: who the end clients are, their current situation, their pain, what they have tried before, what they want, any specific demographic or behavioral details the user mentioned.'."\n";
                $sys.='Core section 3 — The transformation: where the client is before finding this product and where they end up after, in the most specific and measurable terms the user provided.'."\n";
                $sys.='Core section 4 — Proof and results: every case study, result, number, name, and timeframe the user mentioned. Include founder personal results and any aggregate platform or product-level results. Keep every figure exactly as stated.'."\n";
                $sys.='Core section 5 — The offer: pricing, entry points, tiers, what is included, what is excluded, bonuses, guarantees, trial periods, restrictions, and any urgency or scarcity elements.'."\n";
                $sys.='Core section 6 — Top selling points: identify and write out the 3 to 5 most powerful, specific, emotionally resonant facts from everything the user shared — the details most likely to make a prospect immediately say yes. Use the user\'s exact words and numbers. Explain briefly why each one is powerful.'."\n";
                $sys.='Core section 7 — Gaps and missing information: list every funnel-critical area where the user provided little or no information. Be specific — name exactly what is missing and why it matters for the funnel. Funnel-critical areas include: specific transformation with measurable outcome, concrete proof points, emotional triggers of the audience, objections and how they are handled, exact offer details, and audience psychology. If nothing is missing, say so clearly.'."\n";
                $sys.='After the core sections, carefully read through everything the user shared and identify any additional topics that emerged naturally from their specific business, niche, or conversation. For each such topic where the user provided meaningful information, create a new section and name it yourself based on the actual content. Do not create a section if the user provided little or nothing on that topic — only write sections that are genuinely populated with real user-provided detail. These additional sections might cover things like: partner or affiliate program, competitive landscape, emotional landscape of the audience, sales and marketing channels, onboarding and support, community, licensing, content strategy, objection handling, pricing psychology, or anything else unique to this person\'s business. The list of possible topics is open-ended — you decide based on what was actually shared.'."\n";
                $sys.='Output only the profile text. No meta-commentary, no introduction like "Here is the profile", no closing remarks. Begin directly with the first section heading.'."\n";
            
                $model='cldl';
                if($result){
                    $text_content=fs($result,"content");
                    if($text_content){
                        sql("set",["id"=>$profileid,"k"=>"content","v"=>$text_content,"t"=>"aih_ent","prms"=>1]);
                        $run_again=1;
                        sql("set",["id"=>$profileid,"k"=>"full_filled","v"=>1,"t"=>"aih_ent","prms"=>1]);
                        $noanswer=1;
                    }
                }
            
            }
        }
        //------------------------------------------------------------------------------------
        $state='asking_questions';
        $states[$state]=[
            'n'=>'When the user has questions about platform, we use rug to find answers',
            //'visible_on_init'=>1,
        ];
        if($slug=='asking_questions'){

        }
        //------------------------------------------------------------------------------------
        $state='global_settings_json';
        $states[$state]=[
            'n'=>'When the user wants to configure global settings',
        ];
        if($slug=='global_settings_json'){

        }
        //------------------------------------------------------------------------------------
        $state='broadcasting_json';
        $states[$state]=[
            'n'=>'When the user wants to configure broadcasting',
        ];
        if($slug=='broadcasting_json'){

        }
        //------------------------------------------------------------------------------------
        $state='affiliate_program_json';
        $states[$state]=[
            'n'=>'When the user wants to configure affiliate program',
        ];
        //------------------------------------------------------------------------------------
        $state='strategy_build';
        $states[$state]=[];
        if($slug=='strategy_build'){
            $noprevconv=1;
            $model='grokst';
            $model='cldl';
            
            $temp_vars=aih('temp_vars',['sessionid'=>$sessionid,'require'=>['fgid','profileid']]);
            $fgid=fs($temp_vars,'fgid');
            $profileid=fs($temp_vars,'profileid');
            $profile=fs(aih('get',['t'=>'ent','id'=>$profileid]),0);
            $profile_prms=fs($profile,'params');
            $profile_content=fs($profile_prms,'content');
            $fg=fs(fg('get',['id'=>$fgid]),0);
            $aih_strategy=fsp('aih_strategy',$fgid);
            if(!$aih_strategy){
                $aih_strategy=aih('create',['t'=>'ent','name'=>fs($fg,'name'),'slug'=>'strategy','uniq'=>$fgid]);
                sql('set',['id'=>$fgid,'k'=>'aih_strategy','v'=>$aih_strategy,'t'=>'func_group','prms'=>1]);
            }
            $strategy=fs(aih('get',['t'=>'ent','id'=>$aih_strategy]),0);
            $strategy_prms=fs($strategy,'params',[]);
            

            
            $sys='';
            $sys .= 'You are helping the user create and approve a marketing strategy for their business based on the information in "<client_context>".'."\n";
            $sys .= 'Speak the same language as in "<client_context>". Translate all platform entity names into that language.'."\n\n";
            $sys .= 'Do not introduce yourself, start from your task.'."\n";

            $sys .= '<goal>'."\n";
            $sys .= 'Guide the user through: clarifying questions → strategy presentation → iteration → approval.'."\n";
            $sys .= '</goal>'."\n\n";

            $sys .= '<flow>'."\n";
            $sys .= '1. CLARIFY: Do NOT introduce yourself, tell the user you\'ll create a marketing strategy together. Share your assumptions about their needs and ask focused questions (funnel length, goals, key actions). Offer to help if they lack ideas.'."\n";
            $sys .= '2. PRESENT: Based on their answers, present ONE concise strategy (300-500 words). End with: "Do you approve this strategy as is, or would you like to suggest changes?" No other questions, no tool calls.'."\n";
            $sys .= '3. ITERATE: If they request changes, incorporate them and present the updated strategy. If something is vague, ask 1-3 clarifying questions max. Always end by asking for approval.'."\n";
            $sys .= '4. FINALIZE: Only when the user clearly accepts the final version, call "strategy_save_and_go_next" immediately with no extra commentary. See <output_format> for the tool structure.'."\n";
            $sys .= '</flow>'."\n\n";

            $sys .= '<output_format>'."\n";
            $sys .= 'When calling "strategy_save_and_go_next", take the exact strategy text you presented to the user and split it into stages.'."\n";
            $sys .= 'Do NOT rewrite, summarize, or transform the strategy into technical instructions. Keep the original wording as-is.'."\n";
            $sys .= 'Each stage object has:'."\n";
            $sys .= '- "stage": integer, starting from 0'."\n";
            $sys .= '- "name": the stage name as it appeared in the strategy'."\n";
            $sys .= '- "description": the exact text from the strategy that belongs to this stage, preserving the original narrative, explanations, and tone'."\n";
            $sys .= 'The "overview" section that describes the overall customer journey should be included in stage 0 description as a prefix.'."\n";
            $sys .= 'The closing summary section (if any) should be included in the last stage description as a suffix.'."\n";
            $sys .= '</output_format>'."\n\n";

            $sys .= '<strategy_guidelines>'."\n";
            $sys .= '- Structure around a customer journey narrative: one-sentence overview, then a story from awareness to purchase highlighting the customer\'s experience and emotions at each stage.'."\n";
            $sys .= '- Always include stage 0 for entry'."\n";
            $sys .= '- Name each funnel stage by its key action. Make the funnel multi-stage with clear progression.'."\n";
            $sys .= '- Keep it high-level and human-readable. Minimize technical platform jargon. Focus on the big picture: what happens, why, and what the owner gains.'."\n";
            $sys .= '- The funnel works across all channels simultaneously. Traffic acquisition is outside the platform\'s scope.'."\n";
            $sys .= '- For long funnels, extend the 24-hour messaging window by prompting the client to send a message.'."\n";
            $sys .= '- Only use platform features the user actually needs — not everything available.'."\n";
            $sys .= '- If the user requests features not supported by the platform, decline and explain why.'."\n";
            $sys .= '</strategy_guidelines>'."\n\n";

            $sys .= '<critical_constraints>'."\n";
            $sys .= '- Never confuse platform functionality with the client\'s product. The platform does not integrate with client products. External links via buttons are possible, and button clicks can trigger events.'."\n";
            $sys .= '- All proposed steps must be implementable within the platform\'s node editor, pages, and available features.'."\n";
            $sys .= '- If the user suggests overly complex or unsupported features, gently explain that simpler approaches tend to perform better — and propose a straightforward alternative achievable within the platform. Avoid overcomplicating strategies: a lean, focused funnel almost always outperforms an elaborate one.'."\n";
            $sys .= '- Never call "strategy_save_and_go_next" until the user explicitly approves the final strategy.'."\n";
            $sys .= '</critical_constraints>'."\n\n";

            $sys .= '<platform_functions>' . json_encode(aih('arch_pl', ['fgid'=>$fgid,'for_strategy'=>1]), JSON_UNESCAPED_UNICODE) . "</platform_functions>\n";
            $sys .= '<client_context>' . (is_array($profile_content)?json_encode($profile_content, JSON_UNESCAPED_UNICODE):txt_d($profile_content)).'</client_context>';

            

            $tools[]=[
                'type'=>'function',
                'function'=>[
                    'name'=>'strategy_save_and_go_next',
                    'description'=>'Call this step when a user is ready to go further after providing the information. Split the approved strategy text into stages without rewriting it.',
                    'parameters'=>[
                        'type'=>'object',
                        'properties'=>[
                            'stages'=>[
                                'type'=>'array',
                                'description'=>'The approved strategy split by stages. Each description should contain the original strategy text for that stage as presented to the user.',
                                'items'=>[
                                    'type'=>'object',
                                    'properties'=>[
                                        'stage'=>[
                                            'type'=>'integer',
                                            'description'=>'Stage number starting from 0',
                                        ],
                                        'name'=>[
                                            'type'=>'string',
                                            'description'=>'Stage name as it appeared in the strategy',
                                        ],
                                        'description'=>[
                                            'type'=>'string',
                                            'description'=>'The original strategy text for this stage, preserved as-is',
                                        ],
                                    ],
                                    'required'=>['stage','name','description'],
                                    'additionalProperties'=>false,
                                ],
                            ],
                        ],
                        'required'=>['stages'],
                        'additionalProperties'=>false,
                    ],
                ],
            ];
            if($result){
                $tool_calls=fs($result,'tool_calls',[]);
                if($tool_calls){
                    foreach ($tool_calls as $key=>$tool_call){
                        $function=fs($tool_call,'function');
                        $function_name=fs($function,'name');
                        $arguments=fs($function,'arguments',[]);
                        $strategy_stages=fs($arguments,'stages',[]);
                        $strategy_stages=json_repair($strategy_stages);
                        if(is_array($strategy_stages)){
                            $noanswer=1;
                            $run_again=1;
    
                            $taskid=aih('create',['t'=>'ent','name'=>fs($strategy,'name'),'slug'=>'task','sessionid'=>$sessionid,'uniq'=>'task_'.$fgid]);
                            sql("set",["id"=>fs($aimes,"id"),"k"=>"taskid","v"=>$taskid,"t"=>"aih_message","prms"=>1]);
                            sql('set',['id'=>$taskid,'k'=>'content','v'=>'Please create strategy plan fully','t'=>'aih_ent','prms'=>1]);
                            sql('set',['id'=>$taskid,'k'=>'new_funnel','v'=>1,'t'=>'aih_ent','prms'=>1]);
                            sql("set",["id"=>fs($strategy,'id'),"k"=>"content","v"=>$strategy_stages,"t"=>"aih_ent","prms"=>1]);
                        }
                    }
                }
            }
        }
        //------------------------------------------------------------------------------------
        $state='need_questions';
        $states[$state]=[];
        if($slug=='need_questions'){
            $strategy_content=fs(fs(fs($data_fast,'strategy'),'params'),'content');
            $strategy_prms=fs(fs($data_fast,'strategy'),'params',[]);
            $task_prms=fs(fs($data_fast,'task'),'params');
            $is_new_funnel=fs($task_prms,'new_funnel');
            $taskid=fs($data_fast,'taskid');
            $profile_content=fs(fs(fs($data_fast,'profile'),'params'),'content');
            $visual_pref=fs($strategy_prms,'visual_pref');
            $media=fs($strategy_prms,'media');
            $media_refusal_note=fs($strategy_prms,'media_refusal_note');
        
            $sys='';
            $sys.='Now your task is to ask the user two questions about their funnel setup'."\n";
            $sys.='User language is the same as in <funnel_strategy>'."\n";
            $sys.='Firstly, tell the user that we are going to create their funnel based on their strategy. And now we need to clarify a couple of things before we start'."\n";
            $sys.="\n";
            $sys.='--- QUESTION 1: Images ---'."\n";
            $sys.='First, analyze the content of <funnel_strategy> to determine how many key steps are in this funnel. Key steps are typically the main stages or phases in the funnel process described in the task (e.g., awareness, consideration, decision, etc., or any explicitly outlined steps). Count them explicitly and reason step-by-step about the count'."\n";
            $sys.='Then, calculate the approximate spending: (number_of_steps * 2 * 0.15) dollars. This is the estimated cost for generating about two images per key step using the NanoBananaPro ai model'."\n";
            $sys.='Present this information to the user and ask: Would you prefer having generated images in your funnel? If so, we will use the NanoBananaPro ai model for generating images, and for each key step we will generate about two images. Based on the funnel task, there are approximately [insert number] key steps, so the approximate cost would be [insert calculated amount] dollars'."\n";
            $sys.="\n";
            $sys.='--- QUESTION 2: Platform branding sync ---'."\n";
            $sys.='Also ask the user whether they would like to apply the visual styling of this funnel (colors, fonts, button styles) to their entire platform branding and global settings'."\n";
            $sys.='Explain to the user what this means in simple terms: our platform has global branding settings that control how the entire platform looks — including button colors, menu colors, label colors, general styling and appearance. If the user chooses yes, we will automatically update these global platform settings to match the visual style of this funnel, so their whole platform looks consistent and on-brand with their funnel'."\n";
            $sys.='Mention that this option is especially recommended for users who are creating their first funnel on our platform, since they likely have not customized their platform branding yet and this is a great way to set it up automatically'."\n";
            $sys.="\n";
            $sys.='Present both questions together in one message. Wait for the user\'s response. Interpret the answers to determine yes or no for each question. If any answer is unclear, ask for clarification only for that specific question.'."\n";
            $sys.='Once you have clear answers for both questions, call the "set_funnel_preferences" tool with both preferences'."\n";
            $sys.="\n";
            $sys.='<funnel_strategy>'.json_encode($strategy_content,JSON_UNESCAPED_UNICODE).'</funnel_strategy>'."\n";
    
            $tools[]=[
                'type'=>'function',
                'function'=>[
                    'name'=>'set_funnel_preferences',
                    'description'=>'Record the user\'s preference on using generated images in the funnel and on syncing platform branding with funnel styling, then proceed to the next stage',
                    'parameters'=>[
                        'type'=>'object',
                        'properties'=>[
                            'use_images'=>[
                                'type'=>'boolean',
                                'description'=>'True if the user wants to use generated images, false otherwise.'
                            ],
                            'sync_branding'=>[
                                'type'=>'boolean',
                                'description'=>'True if the user wants to apply funnel visual styling to their global platform branding settings, false otherwise.'
                            ],
                        ],
                        'required'=>['use_images','sync_branding'],
                        'additionalProperties'=>false,
                    ],
                ],
            ];
            $tool_calls=fs($result,'tool_calls');
            if($tool_calls){
                foreach ($tool_calls as $key=>$tool_call){
                    $function=fs($tool_call,'function');
                    $function_name=fs($function,'name');
                    $arguments=fs($function,'arguments',[]);
                    $use_images=fs($arguments,'use_images');
                    $sync_branding=fs($arguments,'sync_branding');
                    $noanswer=1;
                    $run_again=1;
                    sql('set',['id'=>$taskid,'k'=>'use_images','v'=>$use_images,'t'=>'aih_ent','prms'=>1]);
                    sql('set',['id'=>$taskid,'k'=>'sync_branding','v'=>$sync_branding,'t'=>'aih_ent','prms'=>1]);
                    sql('set',['id'=>$taskid,'k'=>'need_questions','v'=>1,'t'=>'aih_ent','prms'=>1]);
                }
            }
        }
        //-----------------------------------------------------------------------------------
        $state='visual_pref_get';
        $states[$state]=[];
        if($slug=='visual_pref_get'){
            //$model='grokst';
            $model='cldl';

            $fgid=fs($data_fast,'fgid');
            $strategyid=fs($data_fast,'strategyid');
            $strategy_content=fs(fs(fs($data_fast,'strategy'),'params'),'content');
            $profile_content=fs(fs(fs($data_fast,'profile'),'params'),'content');
            $taskid=fs($data_fast,'taskid');
            $task_prms=fs(fs($data_fast,'task'),'params');
            $task_content=fs($task_prms,'content');
            $new_funnel=fs($task_prms,'new_funnel');

            $sys='';
            $sys .= 'You are a senior creative director and brand strategist who analyzes the "<client_task>" to build a comprehensive visual design concept for the funnel.' . "\n";
            $sys .= 'At the beginning, tell the user that we have started working on their task and that this step is essential to ensure all visuals across the funnel look cohesive, premium, and professionally designed — not generic.' . "\n";

            if ($new_funnel) {
                $sys .= 'Tell the user that now we will define the complete visual identity for the entire funnel.' . "\n";
            }

            $sys='';

            // === ROLE & MINDSET ===
            $sys .= 'You are a senior creative director and visual branding strategist helping the client define a premium visual identity for their funnel.' . "\n";
            $sys .= 'You think like a high-end designer who creates cohesive brand experiences — not generic templates.' . "\n";
            $sys .= 'Your goal is to extract or propose a DESIGN CONCEPT — a unified visual story that ties every page, image, and cover together into a polished, professional whole.' . "\n\n";

            // === OPENING ===
            $sys .= 'At the beginning, warmly tell the user that we have started working on their task, and that before building anything, we need to define the visual direction — because consistent, intentional design is what separates amateur funnels from high-converting, premium-looking ones.' . "\n";
            if ($new_funnel) {
                $sys .= 'Tell the user that now is the perfect time to define the complete visual style for their entire funnel.' . "\n";
            }
            $sys .= "\n";

            // === DESIGN CONCEPT PROPOSAL ===
            $sys .= '## Your Design Concept Proposal' . "\n";
            $sys .= 'Based on the <funnel_strategy> and the niche/industry, propose a complete DESIGN CONCEPT. This is NOT just "use blue and modern fonts". A design concept includes:' . "\n";
            $sys .= '1. **Visual Mood** — the overall emotional feeling (e.g., warm & aspirational, sleek & authoritative, cozy & intimate, bold & energetic)' . "\n";
            $sys .= '2. **Background World** — a specific, realistic visual environment that fits the niche. This is CRITICAL. Backgrounds must feel like real places or scenes relevant to the audience\'s world. Examples: a sunlit modern kitchen for a cooking niche, a panoramic mountain trail for fitness, a polished mahogany desk in a corner office for business consulting, an airy coastal terrace for wellness/lifestyle, a bustling city street at golden hour for urban fashion. The background creates the "world" the funnel lives in. NEVER default to plain solid colors, generic gradients, or meaningless abstract shapes unless the user explicitly asks for them. Always ground backgrounds in reality — real interiors, real nature, real environments that the target audience aspires to or relates to. Think of it as choosing a film set for the brand.' . "\n";
            $sys .= '3. **Color Direction** — not just "blue", but a mood-driven palette described in feeling (e.g., "deep navy paired with warm gold accents and cream — feels trustworthy yet premium", "sage green with soft terracotta and off-white — organic and calming")' . "\n";
            $sys .= '4. **Typography Feel** — described in human terms the user can understand: bold and confident? Light and elegant? Rounded and friendly? Sharp and modern? Do NOT use font names — describe the character of the text.' . "\n";
            $sys .= '5. **Image Style** — what the photos/generated images should feel like: soft natural light? High contrast editorial? Warm and candid? Clean and minimal? Cinematic with depth of field?' . "\n";
            $sys .= '6. **Composition & Layout Feel** — spacious with lots of breathing room? Dense and information-rich? Magazine-editorial style? Clean grid-based?' . "\n";
            $sys .= '7. **Lighting & Atmosphere** — golden hour warmth? Bright and airy? Moody and dramatic? Soft diffused studio light?' . "\n\n";

            $sys .= 'Present your proposed design concept as a cohesive narrative in 4-6 sentences, painting a vivid picture of what the funnel will look and feel like. Make it exciting and specific — the user should be able to VISUALIZE the result.' . "\n";
            $sys .= 'Also briefly explain WHY this concept fits their niche and audience (1-2 sentences).' . "\n\n";

            // === GATHERING USER INPUT ===
            $sys .= '## Gathering User Preferences' . "\n";
            $sys .= 'After presenting your concept, tell the user that NanoBananaPro AI generator will create and enhance all images and covers for the funnel based on this visual direction.' . "\n";
            $sys .= 'Ask the user:' . "\n";
            $sys .= '- Do they like the proposed direction, or would they prefer a different mood/feel?' . "\n";
            $sys .= '- Do they have any color preferences or colors they want to avoid?' . "\n";
            $sys .= '- Any preferences on text density — do they prefer image-heavy pages with minimal text, or text-rich informative layouts?' . "\n";
            $sys .= '- Any real-world environments, places, or settings they associate with their brand? (e.g., "I love the feel of Scandinavian interiors" or "Think luxury resort vibes")' . "\n";
            $sys .= '- Any visual references, brands, or websites whose look they admire?' . "\n";
            $sys .= 'Keep the questions conversational and easy. The user is not a designer — frame everything in everyday language.' . "\n";
            $sys .= 'Do NOT overwhelm with all questions at once. Start with the most important ones (reaction to your concept + any strong preferences), then dig deeper in follow-up turns if needed.' . "\n\n";

            // === MULTI-TURN & CONFIRMATION ===
            $sys .= '## Multi-Turn Interaction' . "\n";
            $sys .= 'This interaction may take several turns. Continue refining the design concept based on user feedback until the user explicitly confirms they are satisfied or have no further preferences.' . "\n";
            $sys .= 'If the user has no preferences at all, acknowledge this warmly and confirm you will proceed with your proposed design concept.' . "\n";
            $sys .= 'Do NOT call the "save_visual_pref" tool until you have received a clear, explicit confirmation from the user that they are done providing input.' . "\n\n";

            // === WHAT TO SAVE (CRITICAL FOR IMAGE GENERATION QUALITY) ===
            $sys .= '## When Saving — Compile a Rich Visual Brief' . "\n";
            $sys .= 'When you finally call save_visual_pref, the "visual_pref" field must be a comprehensive visual brief that an AI image generator can use to produce CONSISTENT, HIGH-QUALITY, PROFESSIONAL images. It should include ALL of the following:' . "\n";
            $sys .= 'IMPORTANT: The final "visual_pref" text must be concise and no longer than approximately 2000 characters. Be vivid but compact — avoid redundancy and filler.' . "\n";
            $sys .= '- Overall visual mood and emotional tone' . "\n";
            $sys .= '- Specific background environments/scenes to use (described vividly enough for image generation — e.g., "soft-focus modern minimalist living room with floor-to-ceiling windows, natural light streaming in, neutral tones with green plant accents")' . "\n";
            $sys .= '- Color palette described with specific color names and their emotional purpose' . "\n";
            $sys .= '- Typography character description' . "\n";
            $sys .= '- Photography/image style (lighting type, contrast level, depth of field, warmth/coolness)' . "\n";
            $sys .= '- Composition guidelines (spacing, density, alignment style)' . "\n";
            $sys .= '- Texture and material notes if relevant (e.g., "natural textures like wood, linen, stone" or "sleek materials like glass, metal, polished surfaces")' . "\n";
            $sys .= '- Any specific "DO NOT" constraints (e.g., "avoid cartoonish illustrations", "no neon colors", "no generic stock photo poses")' . "\n";
            $sys .= '- A one-sentence "elevator pitch" of the visual identity that can serve as a consistent style anchor for every image generated' . "\n\n";

            // === QUALITY ANCHORS ===
            $sys .= '## Quality Anchors for Professional Output' . "\n";
            $sys .= 'To ensure the design looks expensive and professional, always incorporate these principles into the visual brief:' . "\n";
            $sys .= '- Specify LIGHTING precisely (it is the single biggest factor in image quality — "golden hour side lighting", "bright overcast soft diffusion", "dramatic rim lighting with dark background")' . "\n";
            $sys .= '- Include DEPTH and DIMENSION cues (foreground/background blur, layered elements, atmospheric haze)' . "\n";
            $sys .= '- Reference REAL MATERIALS and TEXTURES rather than flat digital surfaces' . "\n";
            $sys .= '- Favor CINEMATIC or EDITORIAL photography styles over stock-photo aesthetics' . "\n";
            $sys .= '- Include atmosphere keywords: "high-end", "refined", "editorial quality", "magazine-worthy", "cinematic", "professionally lit"' . "\n";
            $sys .= '- Backgrounds should always feel like REAL ENVIRONMENTS with depth, context, and story — not flat backdrops' . "\n\n";

            // === LANGUAGE ===
            $sys .= 'Always respond in the same language as the <funnel_strategy> is written in, to match the user\'s language.' . "\n";
            $sys .= 'Write in a warm, professional, but simple and accessible manner. Use well-formatted markdown.' . "\n\n";

            // === TASK CONTEXT ===
            if ($new_funnel) {
                $sys .= '<client_task>The client wants to create a new funnel from scratch based on their strategy.' . "</client_task>\n";
                $sys .= '<funnel_strategy>'.json_encode($strategy_content,JSON_UNESCAPED_UNICODE). "</funnel_strategy>\n";
            } else {
                $sys .= '<client_task>' . $task_content . "</client_task>\n";
            }

            // === TOOL DEFINITION ===
            $tools[]=[
                'type'=>'function',
                'function'=>[
                    'name'=>'save_visual_pref',
                    'description'=>'Call this tool ONLY after the user has explicitly confirmed they are done providing visual preferences or have no preferences. Saves the compiled comprehensive visual brief for use in funnel image generation.',
                    'parameters'=>[
                        'type'=>'object',
                        'properties'=>[
                            'visual_pref'=>[
                                'type'=>'string',
                                'description'=>'A comprehensive visual design brief including: (1) visual mood and emotional tone, (2) specific background environment descriptions with vivid scene details for AI image generation, (3) color palette with named colors and their purpose, (4) typography character, (5) photography/image style including lighting, contrast, depth of field, (6) composition and layout feel, (7) texture/material notes, (8) specific constraints and things to avoid, (9) one-sentence style anchor for consistency. This brief must be detailed enough that an AI image generator can produce consistent, high-end, professional visuals across all funnel assets. The total text MUST NOT exceed approximately 2000 characters.',
                            ],
                            'refusal_note'=>[
                                'type'=>'string',
                                'description'=>'If the user refused to provide preferences, include a brief note here (e.g., "User has no preferences — using proposed design concept"). Otherwise, omit this property.',
                            ],
                        ],
                        'required'=>['visual_pref'],
                        'additionalProperties'=>false,
                    ],
                ],
            ];
            $tool_calls=fs($result,'tool_calls');
            if($tool_calls){
                $visual_pref=fs(fs(fs(fs($tool_calls,0),'function'),'arguments'),'visual_pref');
                if($visual_pref){
                    sql('set',['id'=>$strategyid,'k'=>'visual_pref','v'=>$visual_pref,'t'=>'aih_ent','prms'=>1]);
                    $run_again=1;
                }
            }
        }
        //------------------------------------------------------------------------------------
        $state='media_get';
        $states[$state]=[];
        if($slug=='media_get') {
            $model='grokst';
            $model='clds';
            $thinking=['type'=>'enabled','budget_tokens'=>10000];
            $update_media=fs($arr,'update_media');
            $fgid=fs($data_fast,'fgid');
            $arch_pl=aih('arch_pl',['fgid'=>$fgid]);
            $nodes_list=fs(fs($arch_pl,'nodes'),'list', []);
            $strategyid=fs($data_fast,'strategyid');
            $strategy=fs($data_fast,'strategy');
            $strategy_prms=fs($strategy,'params');
            $strategy_content=fs($strategy_prms,'content');
            $profile_content=fs(fs(fs($data_fast,'profile'),'params'),'content');
            $taskid=fs($data_fast,'taskid');
            $task_prms=fs(fs($data_fast,'task'),'params');
            $task_content=fs($task_prms,'content');
            $new_funnel=fs($task_prms,'new_funnel');
        
            $maximum=$max_files;
        
            // ===== SHARED RULES (both states) =====
            $sys_shared='';
            $sys_shared.='For each NEW image the user uploads, provide a detailed description in exactly 3 sentences, covering: 1) its content, 2) key elements, 3) potential uses in the funnel, and 4) any notable features. Then ask the user to explain or confirm the meaning and intended purpose of this image in the context of the funnel (e.g., "Is this a photo of yourself to use as a personal brand on covers? Or is it a client case study image?"). Explain that you are asking about meaning because according to that meaning you will put those images in different appropriate parts of the funnel.' . "\n";
            $sys_shared.='Collect the user\'s response on the meaning before proceeding to the next image or confirmation.' . "\n";
            $sys_shared.='This interaction may be multi-turn: Continue until the user explicitly confirms they are done or clearly refuses.' . "\n";
            $sys_shared.='Always respond in the same language as the <client_task> is written in, to match the user\'s language.' . "\n";
            $sys_shared.='Tell the user that they could attach images by dropping them to the chat area or by clicking the paperclip icon.' . "\n";
            $sys_shared.='Maximum total images allowed: ' . $maximum . '.' . "\n";
            $sys_shared.="\n";
            $sys_shared.='CRITICAL RULES:' . "\n";
            $sys_shared.='1. Once the user confirms they are done (or refuses), you MUST immediately call the "save_medias" tool in that same response. Do NOT respond with plain text only — the tool call is mandatory.' . "\n";
            $sys_shared.='2. Your ONLY task in this phase is to collect/update images. Do NOT create funnel content, do NOT write page texts, do NOT build the funnel, do NOT generate scripts or strategies. Just handle images and call the tool.' . "\n";
            $sys_shared.='3. After calling "save_medias", say a short confirmation and STOP. Do not proceed further.' . "\n";
            $sys_shared.='Write in a simple manner and use well-formatted markdown.' . "\n";
        
            $sys='';
        
            if (!$update_media) {
                // ===== NEW FUNNEL: collect images from scratch =====
                $sys.='You are an agent that analyzes the <client_task> to determine if any images or visual assets are needed from the user to complete it effectively. Images are entirely optional and should only be requested if they add clear value to the task.' . "\n";
                $sys.='First, evaluate the <client_task>: If it is simple (e.g., "Change some text on a website block"), no images are needed. If it is more complex (e.g., "Create a full funnel strategy", "Build a page with multiple blocks"), images may be useful for page blocks, messages, or visual branding.' . "\n";
                $sys.='Start your response by explaining to the user what this step involves (gathering relevant images) and why it\'s important for enhancing the funnel\'s visual appeal and effectiveness.' . "\n";
                if ($new_funnel) {
                    $sys.='Explain that we will use these images in message covers, page covers, page blocks, and similar elements to personalize and strengthen the funnel.' . "\n";
                }
                $sys.='IMPORTANT: Before requesting images, carefully analyze the <user_context> and <funnel_strategy> to understand the user\'s NICHE, PRODUCT TYPE, and BUSINESS MODEL. Your image recommendations MUST be tailored to their specific business.' . "\n";
                $sys.="\n";
                $sys.='IMAGE CATEGORIES — request images from BOTH categories below, prioritizing Category B:' . "\n";
                $sys.="\n";
                $sys.='**Category A: Personal brand photos (max 2)**' . "\n";
                $sys.='- Only if the person IS the brand (coach, expert, founder as the face of the business).' . "\n";
                $sys.='- Ask for a clear, front-facing, well-lit photo.' . "\n";
                $sys.='- If the product is the star (not the person), skip this category entirely or limit to 1.' . "\n";
                $sys.="\n";
                $sys.='**Category B: Product & business visuals (this is the PRIORITY category)**' . "\n";
                $sys.='- Analyze the user\'s niche from <user_context> and recommend SPECIFIC types of product images. Examples by niche:' . "\n";
                $sys.='  • Software/SaaS/Platform → screenshots of the interface, dashboard, key features in action, demo results, before/after comparisons of what the tool produces' . "\n";
                $sys.='  • Physical products (supplements, cosmetics, food, goods) → product photos (packaging, the product itself, product in use), lifestyle shots with the product' . "\n";
                $sys.='  • Services (consulting, marketing, design) → examples of work results, case study visuals, before/after client transformations' . "\n";
                $sys.='  • Education/Courses → screenshots of course content, student results, certificates, learning interface' . "\n";
                $sys.='  • E-commerce/Retail → product catalog photos, bestsellers, product in context/lifestyle' . "\n";
                $sys.='  • Real estate/Travel → property photos, location shots, interior/exterior views' . "\n";
                $sys.='- ALWAYS recommend uploading the company LOGO if the business has one.' . "\n";
                $sys.='- ALWAYS think: "What would a potential customer want to SEE to trust this product?" — and request those specific visuals.' . "\n";
                $sys.="\n";
                $sys.='When making your request, be SPECIFIC to the user\'s niche. Do NOT give generic advice like "upload product photos". Instead, name exactly what kind of images would work. For example, if the user sells a software platform, say something like: "Upload 2-3 screenshots showing the most impressive parts of your platform — the interface, an example of a result it produces, or a demo in action. Also upload your logo if you have one." Tailor this to whatever their business actually is.' . "\n";
                $sys.="\n";
                $sys.='Mention that we will use NanoBananaPro AI generator to create varied covers, and that providing different related and real images (BOTH personal AND product) will help achieve much better, more convincing results.' . "\n";
                $sys.='Encourage the user to imagine how their funnel should look visually, as AI cannot read minds.' . "\n";
                $sys.='Request 3-5 images ideally (mix of personal + product). Do not overwhelm the user but make sure product visuals are not forgotten.' . "\n";
                $sys.='If the user refuses to provide images or indicates they are unnecessary, note this and proceed without them.' . "\n";
                $sys.="\n";
                $sys.=$sys_shared;
                $sys.="\n";
                $sys.='<client_task>The client wants to create a new funnel from scratch based on their strategy</client_task>'."\n";
                $sys.='<funnel_strategy>'.json_encode($strategy_content,JSON_UNESCAPED_UNICODE)."</funnel_strategy>\n";
        
            } else {
                // ===== UPDATE MEDIA: modify existing image set =====
                $media=fs($strategy_prms,'media');
                $has_existing=is_array($media) && count($media)>0;
        
                $sys.='You are an agent that helps the user update their reference images for an existing funnel. The user wants to modify their current set of images — they may want to replace some, remove some, add new ones, or update descriptions/meanings of existing ones.' . "\n\n";
        
                if ($has_existing) {
                    $sys.='The user currently has the following images attached to their funnel (shown in <current_media>). Start by presenting a clear numbered list of their current images with a short summary of each (name/description + meaning), so the user can see what they have.' . "\n";
                    $sys.='Then ask what they want to do. Possible actions:' . "\n";
                    $sys.='- **Replace** an image: user uploads a new one to replace a specific existing image.' . "\n";
                    $sys.='- **Remove** an image: user wants to delete an image from the set.' . "\n";
                    $sys.='- **Add** new images: user uploads additional images (respect the maximum of ' . $maximum . ' total).' . "\n";
                    $sys.='- **Update description or meaning**: user wants to change how an existing image is described or its intended purpose in the funnel.' . "\n";
                    $sys.='Let the user do multiple actions in any order. After each change, briefly confirm what was changed.' . "\n";
                } else {
                    $sys.='The user currently has NO images attached to their funnel. Ask if they want to upload images now.' . "\n";
                    $sys.='If images are needed, analyze the user\'s niche from <user_context> and <client_task> and request SPECIFIC types of images relevant to their business:' . "\n";
                    $sys.='- Personal brand photo (limit to 2 max, only if the person is the face of the brand).' . "\n";
                    $sys.='- Company logo.' . "\n";
                    $sys.='- Product-specific visuals tailored to niche: software screenshots, physical product photos, service result examples, course previews, etc. Be specific in what you ask for based on their actual business.' . "\n";
                }
        
                $sys.="\n";
                $sys.='When the user confirms they are done with all changes, compile the FINAL complete array of images. This array must include:' . "\n";
                $sys.='- All UNCHANGED images (keep their original mediaid, description, and meaning exactly as-is).' . "\n";
                $sys.='- All MODIFIED images (with updated description and/or meaning).' . "\n";
                $sys.='- All NEW images (with new mediaid, description, and meaning).' . "\n";
                $sys.='- EXCLUDE any images the user asked to remove.' . "\n";
                $sys.='Pass this final complete array to "save_medias". The array replaces the old one entirely, so nothing should be missing.' . "\n";
                $sys.="\n";
                $sys.=$sys_shared;
                $sys.="\n";
        
                if ($has_existing) {
                    $sys.='<current_media>'.json_encode($media,JSON_UNESCAPED_UNICODE)."</current_media>\n";
                }
                $sys.='<client_task>'.fs($task_content,'intention')."</client_task>\n";
            }
        
            $sys.='<user_context>'.(is_array($profile_content)?json_encode($profile_content, JSON_UNESCAPED_UNICODE):txt_d($profile_content))."</user_context>\n";
        
            // ===== TOOL DEFINITION (same for both states) =====
            $tools[]=[
                'type'=>'function',
                'function'=>[
                    'name'=>'save_medias',
                    'description'=>'Call this tool only after the user has explicitly confirmed they are done uploading/updating images or have refused to provide any. It saves the COMPLETE final set of images for the funnel. When updating, include ALL images that should remain (unchanged + modified + new), excluding any removed ones.',
                    'parameters'=>[
                        'type'=>'object',
                        'properties'=>[
                            'medias'=>[
                                'type'=>'array',
                                'description'=>'The complete final array of image objects for the funnel. When updating existing media, include unchanged images with their original data, modified images with updated fields, and any new images. Exclude removed images. If no images at all, leave as empty array. Maximum '.$maximum.' images.',
                                'items'=>[
                                    'type'=>'object',
                                    'properties'=>[
                                        'mediaid'=>[
                                            'type'=>'string',
                                            'description'=>'The URL or identifier of the image. For existing unchanged/modified images, use the original mediaid. For new uploads, use the new identifier.',
                                        ],
                                        'description'=>[
                                            'type'=>'string',
                                            'description'=>'A concise 4-sentence description of the image.',
                                        ],
                                        'meaning'=>[
                                            'type'=>'string',
                                            'description'=>'The intended meaning or purpose of the image in the context of the funnel, as provided or confirmed by the user.',
                                        ],
                                    ],
                                    'required'=>['mediaid','description','meaning'],
                                    'additionalProperties'=>false,
                                ],
                            ],
                            'refusal_note'=>[
                                'type'=>'string',
                                'description'=>'If the user refused to provide or keep any images, include a brief note here. Otherwise, omit this property.',
                            ],
                        ],
                        'required'=>['medias'],
                        'additionalProperties'=>false,
                    ],
                ],
            ];
        
            // ===== HANDLE TOOL RESPONSE (same for both states) =====
            $tool_calls=fs($result,'tool_calls');
            if($tool_calls){
                $arguments=fs(fs(fs($tool_calls,0),'function'),'arguments');
                if(is_array($arguments)){
                    $medias=fs($arguments,'medias');
                    $medias=json_repair($medias);
                    $refusal_note=fs($arguments,'refusal_note');
                    if($refusal_note){
                        sql('set',['id'=>$strategyid,'k'=>'media_refusal_note','v'=>$refusal_note,'t'=>'aih_ent','prms'=>1]);
                    } else if($medias){
                        foreach($medias as $key=>$media){
                            $mediaid=fs($media,'mediaid');
                            sql('set',['id'=>$mediaid,'k'=>'folder','v'=>0,'t'=>'media']);
                        }
                        sql('set',['id'=>$strategyid,'k'=>'media','v'=>$medias,'t'=>'aih_ent','prms'=>1]);
                    }
                    sql('set',['id'=>$strategyid,'k'=>'media_get','v'=>1,'t'=>'aih_ent','prms'=>1]);
                    if($update_media){
                        sql('set',['id'=>$taskid,'k'=>'updated_media','v'=>1,'t'=>'aih_ent','prms'=>1]);
                    }
                    $run_again=1;
                }
            }
        }
        //------------------------------------------------------------------------------------
        $state='task_get';
        $states[$state]=[];
        if($slug=='task_get'){
            //$model='grokst';
            //$model='gmnl';
            $model='clds';
            $fgid=fs($data_fast, 'fgid');
            $arch_fg=aih('arch_fg', ['fgid' => $fgid]);
            $arch_pl=aih('arch_pl', ['fgid' => $fgid]);
            
            
            // ── SYSTEM PROMPT ──
            $sys='';
            $sys.= '<platform_functions>' . json_encode($arch_pl, JSON_UNESCAPED_UNICODE) . '</platform_functions>'."\n";
            $sys.='<funnel_current_state>' . json_encode($arch_fg, JSON_UNESCAPED_UNICODE) . '</funnel_current_state>'."\n";
            $sys.=<<<'PROMPT'

            # Role
            You are a **funnel editing assistant**. You help the user figure out what they want to change in their funnel, then pass a well-gathered request to a smarter execution model via the `stages_edits` tool.

            # CRITICAL RULE
            You CANNOT edit the funnel. You CANNOT apply changes. You have NO ability to modify anything.
            The ONLY way to make changes happen is by calling the `stages_edits` tool.
            If you respond with text describing what you "did" or "changed" without calling the tool — NOTHING happens, the user is deceived, and the funnel stays unchanged.
            NEVER pretend you made changes. NEVER describe the result as if it's done.
            When you have enough information — call the tool. That's it.

            # Your job has two phases

            ## Phase 1 — Conversation & Consultation
            - Help the user understand their current funnel using `<funnel_current_state>`.
            - Answer questions about what's possible using `<platform_functions>`.
            - If the user has a vague idea, help them think through options — suggest briefly, ask what they prefer.
            - Clarify which stages, elements, and content are involved. Users don't know internal IDs — they refer to stages by number or name, nodes by their content (e.g. "the welcome message"), blocks by what they see (e.g. "the buy button"). Always use the same human-readable language.
            - Gather the user's decisions: what to edit, what to add, what to remove, what content or behavior they want.
            - The user may want to edit existing elements, add new stages/nodes/blocks, delete things, or a combination.
            - If the user says something like "do it as you see fit" or "you decide" — that is enough. Accept their delegation, briefly confirm what you'll request, and proceed to Phase 2.

            ### Reference images sub-phase
            Before calling the tool, determine whether the requested changes involve creating or substantially changing visual content.

            **Changes that involve images** (requires asking about reference images):
            - Creating new stages, pages, or message nodes (these will need generated images)
            - Adding new image blocks, replacing existing images
            - Rebuilding or redesigning significant parts of the funnel
            - Any request that will result in new `img_prompt` values being written

            **Changes that do NOT involve images** (skip the question):
            - Editing text in messages or pages (copywriting, typos, wording)
            - Changing button labels, links, delays, conditions, variables
            - Reordering stages, removing elements, adjusting node logic
            - Changing pricing plans, settings, or non-visual properties

            **When changes involve images:**
            Ask the user ONE clear question: do they want to keep the current reference images for generation, or do they want to update their reference images first?
            - Explain briefly: reference images are used as visual source material (brand face, style, photos) when generating all new images in the funnel.
            - If user wants to update them — set `update_media` to `true` in the tool call. The platform will then show them a media selection step before executing edits.
            - If user is fine with current references — set `update_media` to `false`.
            - If user explicitly delegates ("use what's there", "doesn't matter") — set `update_media` to `false`.

            **Special case — user only wants to change reference images:**
            If the user's sole request is to update or replace reference images (without any funnel structure/content edits), call the tool with an empty `edits` array and `update_media` set to `true`. Set the `intention` to describe what the user wants to achieve with new reference images.

            ## Phase 2 — Call the tool
            - When you have enough information and the user has confirmed (or delegated the decision) — call the `stages_edits` tool IMMEDIATELY.
            - Do NOT add any text after the tool call. The tool call must be your final action.
            - Do NOT describe what the result will look like — just call the tool.
            - Do NOT write detailed technical instructions in the tool call — the execution model is smarter and will figure out implementation. Capture WHAT the user wants, not HOW to implement it.
            - Preserve the user's original language and decisions. Add only the context needed for the execution model to understand the request without seeing the conversation history.

            # Important boundaries
            - You suggest and consult, but the user decides. Don't push changes they didn't ask for.
            - Don't invent specific content (message texts, page copy) unless the user asks you to decide. If the user delegates creative decisions, note that in the tool call so the execution model generates the content.
            - When multiple stages are affected, make sure you've discussed all of them before calling the tool.

            PROMPT;
            // ── TOOL DEFINITION ──
            $tools[]=[
                'type' => 'function',
                'function' => [
                    'name' => 'stages_edits',
                    'description' => 'Pass the user\'s fully gathered editing request to the execution model. This is the ONLY way to apply changes to the funnel. Call only after sufficient conversation with the user. Can also be called with empty edits array if user only wants to update reference images.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'intention' => [
                                'type' => 'string',
                                'description' => 'The user\'s goal in their own words — what problem they want to solve or what they want to achieve. Preserve their language and key decisions made during conversation. If user only wants to update reference images, describe their visual goals here.',
                            ],
                            'edits' => [
                                'type' => 'array',
                                'description' => 'One item per stage affected. Existing stages use their ID, new stages use null. Can be empty array if user only wants to update reference images without funnel edits.',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'stage_id' => [
                                            'type' => 'string',
                                            'description' => 'Stage ID from funnel_current_state, or `NEW` for a new stage to be created.',
                                        ],
                                        'task' => [
                                            'type' => 'string',
                                            'description' => 'What the user wants done in this specific stage. Include what to add, change, or remove, and any specific content or preferences the user mentioned. For new stages — where to insert it and its purpose.',
                                        ],
                                    ],
                                    'required' => ['stage_id', 'task'],
                                ],
                            ],
                            'update_media' => [
                                'type' => 'boolean',
                                'description' => 'Set to true if the user wants to update their reference images (media IDs used in img_prompt_media_ids) before the execution model generates new visuals. Set to false if user is fine with current reference images or if changes do not involve image generation at all.',
                            ],
                        ],
                        'required' => ['intention', 'edits', 'update_media'],
                    ],
                ],
            ];
            $tool_calls=fs($result,'tool_calls');
            if($tool_calls){
                $function=fs(fs($tool_calls,0),'function');
                $function_name=fs($function,'name');
                $arguments=fs($function,'arguments',[]);
                $arguments=json_repair($arguments);
                if(is_array($arguments)){
                    $noanswer=1;
                    $run_again=1;

                    $taskid=aih('create',['t'=>'ent','name'=>'For session '.$sessionid,'slug'=>'task','sessionid'=>$sessionid,'uniq'=>'mes_'.fs($aimes,"id")]);
                    sql("set",["id"=>fs($aimes,"id"),"k"=>"taskid","v"=>$taskid,"t"=>"aih_message","prms"=>1]);
                    sql('set',['id'=>$taskid,'k'=>'content','v'=>$arguments,'t'=>'aih_ent','prms'=>1]);
                }
            }
        }
        //-----------------------------------------------------------------------------------
        $state='fill';
        $states[$state]=[];
        if($slug=='fill'){
            $stage_index=fs($arr,'stage_index',0);
            $edit_index=fs($arr,'edit_index',0);
            $is_editing_stage0=($stage_index==0);
            $noprevconv=1;
            $strategyid=fs($data_fast,'strategyid');
            $strategy=fs(aih('get',['t'=>'ent','id'=>$strategyid]),0);
            $strategy_prms=fs($strategy,'params');
            $strategy_content=fs($strategy_prms,'content');
            $taskid=fs($data_fast,'taskid');
            $task=fs(aih('get',['t'=>'ent','id'=>$taskid]),0);
            $task_prms=fs($task,'params');
            $is_new_funnel=fs($task_prms,'new_funnel');
            if($is_new_funnel){
                $use_images=fs($task_prms,'use_images');
            } else {
                $use_images=1;
            }
            
            
            $stgs_id=fs($data_fast,'stgs_id');
            $hidden_slug_suffix='_'.($is_new_funnel?$stage_index:$edit_index);
            $fgid=fs($data_fast,'fgid',fs($conversation,'last_fgid'));
            sql('set',['id'=>$fgid,'k'=>'aih_working','v'=>time(),'t'=>'func_group','prms'=>1]);

            //$model='grokst';
            $model='cldl';
            $arch_fg=aih('arch_fg',['fgid'=>$fgid]);
            $thinking=['type'=>'enabled','budget_tokens'=>10000];
            //$model='cldxl';
            //$thinking=['type'=>'adaptive'];
            /*
            jf('stgs_act',['t'=>'remove','stgs_id'=>'ja4','fgid'=>$fgid]);
            pr(fg('get',['id'=>$fgid]));
            die();*/
            $fg=fs(jf('get',['id'=>$fgid,'validate'=>1]),0);
            
            $fg_prms=fs($fg,'params');
            $arch_pl=aih('arch_pl',['fgid'=>$fgid,'new_funnel'=>$is_new_funnel,'is_editing_stage0'=>$is_editing_stage0]);
            

            $profile_content=fs(fs(fs($data_fast,'profile'),'params'),'content');
            
            
            
            $nodes_all=atm('nodes');
            $elems_all=elem('all',['aih'=>1]);
            
    
            
            
            //'finish'

            

    
            
            

            $presys='';
            $presys.='<platform_functions>'.json_encode($arch_pl,JSON_UNESCAPED_UNICODE).'</platform_functions>'."\n";
            $presys.='<user_context>'.(is_array($profile_content)?json_encode($profile_content, JSON_UNESCAPED_UNICODE):txt_d($profile_content)).'</user_context>'."\n";
            if($use_images){
                $visual_pref=fs($strategy_prms,'visual_pref');
                $media=fs($strategy_prms,'media');
                $img_policy=[
                    'when_to_place'=>'The best practice for visual content of funnel is to have one image somwhere on first screen of every page node and one image on init message node. Unless user asks explicitly to add more images on other messages and blocks or don\'t use them at all',
                    'user_visual_preferences'=>$visual_pref,
                    'how_to_place_image'=>implode('; ',array_filter([
                        'Use "img_prompt" and "img_prompt_media_ids" for reference to create final "img" media ID automatically',
                        'Our AI combines prompt and reference images to create final image without changing faces, loosing important image reference parts, with good design and text',
                        'IMPORTANT: Always make sure we have some text and related to context offers almost on every image unless user asks explicitly to not have them',
                        'IMPORTANT: img_prompt and all texts on image must be on users language do NOT include any variables in image text',
                        'If you plan to add a person from another image, make sure their face is clearly visible. If the face is barely visible or partially turned away, do not use it as a reference — the result will not be recognizable. To improve face recognition accuracy, provide multiple images of the same person whenever possible',
                        'Each time you create image this way, you need to combine context meaning of this image; user visual preferences; and images from media_ids: use their description to understand what is placed there',
                        'If there is some main character on new image, make sure their pose is different from input source, point model to desired new pose of that person',
                        ($media?'Use 1 or 4 or more (in rare cases) images for input source to avoid having final image too generic; always tell AI how to use attached images in final image; If we have a key expert or brand face, try to use them in every image':''),
                        'Don\'t mention resolution; Prefer colored images not bw',
                        'In most cases prefer 1:1 aspect ratio',
                        'Normally our model tries to create ugly design so please make sure you write prompt that aspires to the best quality of design of Behance expensive designers',
                    ])),
                    'reference_media_ids'=>$media,
                ];
                $presys.='<image_policy>'.json_encode($img_policy,JSON_UNESCAPED_UNICODE).'</image_policy>'."\n";
            } else {
                $presys.='<image_policy>Important: Strictly do not create any images through img_prompt, not for message nodes, neither for image blocks! User has asked to not use in any AI image but other images like advantage_icons are allowed</image_policy>'."\n";
            }
            
            $sys='';
            $sys.="\n";
            $sys.='You are the best marketer/developer that can create sales funnels'."\n";
            $sys.='Use tools to fill the funnel with content according to "<user_task>"'."\n";
            $sys.='Use "<platform_functions>" to understand properties of nodes, blocks, funnel settings etc.; "<funnel_current_state>" to understand current funnel content'."\n";
            //$sys.='Final response must be valid to schema, so don\'t use quo double quotes in text'."\n";
            $sys.='At your thinking section think about which nodes and events you need to bind and how to use node_outputs_policy in this task case'."\n";
    
            $sys.='USER LANGUAGE: is on which language "<funnel_strategy>" is written'."\n";
            
            if($is_new_funnel){
                $sys.='<user_task>Fill "<stage'.$stage_index.'>" content using description from "<funnel_strategy>"'.($use_images?' and use "<image_policy>"':'').'. Now you are focusing on only one stage, leave editing other stages for other iterations. Look what is missing in related stage from "<funnel_current_state>" and make sure to fill this stage from plain text instructions. If the related stage already exists in "<funnel_current_state>": NEVER create a new stage entity. Instead, use update on existing node IDs and create only for blocks or nodes that are genuinely missing from that stage. The stage ID must remain the same</user_task>'."\n";
                $sys.='<funnel_strategy>';
                foreach ($strategy_content as $key=>$value){
                    $sys.='<stage'.$key.'>';
                    if($stage_index==$key){
                        $sys.='<focus>';
                    }
                    if($stage_index==0){
                        $sys.='(Do NOT create stage0, it is already created. Strictly update existing stage0) ';
                    }
                    $sys.=fs($value,'name')."\n";
                    $sys.=fs($value,'description')."\n";
                    if($stage_index==$key){
                        $sys.='</focus>';
                    }
                    $sys.='</stage'.$key.'>';
                }
                $sys.="</funnel_strategy>\n";
            } else {
                $task_content=fs($task_prms,'content');
                $intention=fs($task_content,'intention','');
                $edits=fs($task_content,'edits',[]);
                
                $sys.='<user_task>'.implode(' ',[
                    'Edit the funnel according to the focused edit in "<funnel_edits>".',
                    'The user\'s overall intention: "'.$intention.'".',
                    'Now you are focusing on only one edit_section at a time, leave other edits for other iterations.',
                    'Apply changes described in the focused edit to the stage specified by stage_id.',
                    'If stage_id is NEW, create a new stage as described.'.($use_images?' and use "<image_policy>"':''),
                ]).'</user_task>'."\n";

                $sys.='<funnel_edit_sections>';
                foreach ($edits as $key => $value){
                    $sys.='<edit_section'.$key.'>';
                    if($edit_index==$key){
                        $sys.='<focus>';
                    }
                    $sys.='stage_id: '.fs($value,'stage_id','new_stage')."\n";
                    $sys.=fs($value,'task')."\n";
                    if($edit_index==$key){
                        $sys.='</focus>';
                    }
                    $sys.='</edit_section'.$key.'>';
                }
                $sys.="</funnel_edits>\n";
            }
            $sys.='Use "<user_context>" to write marketing texts'."\n";
            $sys.='<funnel_current_state>'.json_encode($arch_fg,JSON_UNESCAPED_UNICODE).'</funnel_current_state>'."\n";
            $sys .= 'Use the single "edit_funnel" tool for ALL funnel changes. It accepts three optional sections in one call:' . "\n";
            $sys .= '  "operations" — create/update/delete entities (processed first, slugs resolve immediately).' . "\n";
            $sys .= '  "connections" — wire node outputs to other nodes (can reference slugs from operations).' . "\n";
            $sys .= '  "settings" — update global funnel configuration.' . "\n";
            $sys .= 'CRITICAL: Always put operations AND connections AND settings (whichever apply) into ONE edit_funnel call. NEVER split them across separate tool calls or turns.' . "\n";
            $sys .= 'IMPORTANT: When calling tools, always return valid structured JSON objects — never stringify arrays or objects into strings.' . "\n";
            $sys.='IMPORTANT: When calling tools, always return valid structured JSON objects — never stringify arrays or objects into strings'."\n";
            //die('died');
            $list_events=fs(jf('elem_events',['aih'=>1,'fgid'=>$fgid]),'base');
            $tools=[
                [
                    'type'=>'function',
                    'function'=>[
                        'name'=>'edit_funnel',
                        'description'=>implode(' ', [
                            'Single tool for ALL funnel modifications.',
                            'Accepts three optional sections processed in order: (1) operations — create/update/delete entities,',
                            '(2) connections — wire node outputs to other nodes,',
                            '(3) settings — update global funnel configuration.',
                            'Slugs created in "operations" are immediately usable in "connections" within the same call.',
                            'Batch everything into ONE call — do NOT split across multiple turns.',
                        ]),
                        'parameters'=>[
                            'type'=>'object',
                            'properties'=>[
                                // ── SECTION 1: ENTITY OPERATIONS (was upsert_entities) ──
                                'operations'=>[
                                    'type'=>'array',
                                    'description'=>'Ordered list of entity create/update/delete operations. Processed sequentially — earlier slugs can be referenced by later items and by "connections".',
                                    'items'=>[
                                        'type'=>'object',
                                        'properties'=>[
                                            'action'=>[
                                                'type'=>'string',
                                                'enum'=>['create', 'update', 'delete'],
                                                'description'=>implode(' ', [
                                                    'create: new entity (requires slug + params),',
                                                    'always specify with create insert_after, insert_before or insert_at.',
                                                    'update: modify existing — send ONLY changed params. Array params (bn, icns, options) must be sent complete.',
                                                    'delete: remove entity (requires id).',
                                                ]),
                                            ],
                                            'entity'=>[
                                                'type'=>'string',
                                                'enum'=>['stage', 'node', 'block', 'quiz_slide', 'variable', 'pricing_plan'],
                                                'description'=>implode(' ', [
                                                    'stage: funnel stage container for nodes; Do not create stages that have already been created, especially stage0, which is always pre-created',
                                                    'node: funnel node (message, page, condition, time, crm, trigger, stage_next, etc.).',
                                                    'block: site block on page or quiz slide.',
                                                    'quiz_slide: slide inside a quiz block.',
                                                    'variable: custom variable usable as {variable_name}.',
                                                    'pricing_plan: pricing plan for the funnel.',
                                                ]),
                                            ],
                                            'id'=>[
                                                'type'=>'string',
                                                'description'=>'Existing entity ID for update/delete. From <funnel_current_state>.',
                                            ],
                                            'slug'=>[
                                                'type'=>'string',
                                                'description'=>'REQUIRED for create. Unique temp ID, referenceable as parent_id or in connections within this batch. Use short names: "welcome_page", "intro_video".',
                                            ],
                                            'insert_after'=>[
                                                'type'=>'string',
                                                'description'=>'ID or slug of sibling to place after. Only used on first creation.',
                                            ],
                                            'insert_before'=>[
                                                'type'=>'string',
                                                'description'=>'ID or slug of sibling to place before.',
                                            ],
                                            'insert_at'=>[
                                                'type'=>'string',
                                                'enum'=>['start', 'end'],
                                                'description'=>'Place at start or end of container.',
                                            ],
                                            'stage_id'=>[
                                                'type'=>'string',
                                                'description'=>'REQUIRED for create+node. Stage ID or slug where this entity belongs.',
                                            ],
                                            'node_type'=>[
                                                'type'=>'string',
                                                'description'=>'For create+node: ' . implode(',', array_keys($nodes_all)),
                                            ],
                                            'block_type'=>[
                                                'type'=>'string',
                                                'description'=>'For create+block: ' . implode(',', array_column($elems_all, 'slug')),
                                            ],
                                            'role'=>[
                                                'type'=>'string',
                                                'enum'=>['', 'init', 'trigger', 'page', 'support', 'next', 'follow1', 'follow2', 'follow3'],
                                                'description'=>'For create+node only: stage placement.',
                                            ],
                                            'parent_type'=>[
                                                'type'=>'string',
                                                'enum'=>['page', 'quiz_slide'],
                                                'description'=>'For blocks: where placed. page (default): on page node. quiz_slide: on quiz slide (needs parent_id=quiz block + slide_id).',
                                            ],
                                            'parent_id'=>[
                                                'type'=>'string',
                                                'description'=>'Parent container ID/slug. For block on page: page node. For block on quiz_slide: quiz block (with slide_id). For quiz_slide: quiz block.',
                                            ],
                                            'slide_id'=>[
                                                'type'=>'string',
                                                'description'=>'For block on quiz_slide: ID/slug which slide to place on.',
                                            ],
                                            'params'=>[
                                                'type'=>'object',
                                                'description'=>'Entity properties. Keys depend on node_type/block_type per platform docs. Create: all required params, skip empty defaults. Update: ONLY changed params, but array params (bn, icns) must be complete.',
                                                'additionalProperties'=>true,
                                            ],
                                        ],
                                        'required'=>['action', 'entity'],
                                    ],
                                ],
            
                                // ── SECTION 2: CONNECTIONS (was connect_nodes) ──
                                'connections'=>[
                                    'type'=>'array',
                                    'description'=>implode(' ', [
                                        'Wire node outputs to other nodes.',
                                        'Slugs from "operations" above are valid references here.',
                                        'Only needed for: page events→stage_next, trigger outputs→stage_next, support node chains, "jf" button outputs, etc.',
                                        'NOT needed for: init messages, follow-ups, stage_page buttons (all auto-wired).',
                                    ]),
                                    'items'=>[
                                        'type'=>'object',
                                        'properties'=>[
                                            'from_node'=>[
                                                'type'=>'string',
                                                'description'=>'Source node ID or slug.',
                                            ],
                                            'to_node'=>[
                                                'type'=>'string',
                                                'description'=>'Target node ID or slug. For removing connection leave this field empty',
                                            ],
                                            'output_index'=>[
                                                'type'=>'integer',
                                                'description'=>implode(' ', [
                                                    'For non-page nodes (1-based).',
                                                    'Single-output (stage_next,time,crm,tnote,request,math,aff): always 1.',
                                                    'Message: 1=NEXT, 2+=buttons in bn order (ALL buttons count for index regardless of type).',
                                                    'Condition: 1..N=groups, N+1=no match.',
                                                    'Trigger: 1..N=triggers. Randomizer: 1..N=chances.',
                                                ]),
                                            ],
                                            'page_event'=>[
                                                'type'=>'object',
                                                'description'=>'For page source nodes only. Use INSTEAD of output_index.',
                                                'properties'=>[
                                                    'block_id'=>[
                                                        'type'=>'string',
                                                        'description'=>'ID or slug of block producing the event.',
                                                    ],
                                                    'event'=>[
                                                        'type'=>'string',
                                                        'enum'=>array_keys($list_events),
                                                        'description'=>'Read node_outputs_policy.page_events.',
                                                    ],
                                                ],
                                                'required'=>['block_id', 'event'],
                                            ],
                                        ],
                                        'required'=>['from_node', 'to_node'],
                                    ],
                                ],
            
                                // ── SECTION 3: FUNNEL SETTINGS (was update_funnel_settings) ──
                                'settings'=>[
                                    'type'=>'object',
                                    'description'=>'Update global funnel configuration (cover, visibility, manager settings). See funnel_settings in platform docs. Only include changed values.',
                                    'additionalProperties'=>true,
                                ],
            
                            ],
                            // None of the three sections is individually required —
                            // but at least one must be present (validated server-side).
                            'required'=>[],
                        ],
                    ],
                ],
            ];
            //die('jjjj');
            $tool_choice=['type'=>'auto'];
            //pr('>>>>>FUNNEL ARCH MAP<<<<<!!!');
            //pr($arch_fg);
            //die();
            $tool_calls=fs($result,'tool_calls');
            $block_next_stages=0;
            if($tool_calls){
                //pr($fgid);
                pr($result);
                //die('here!');
                $arguments=fs(fs(fs($tool_calls,0),'function'),'arguments');
                $arguments=json_repair($arguments);
                $stgs_roles=jf('stgs_roles',['fgid'=>$fgid]);
                global $operate_map;
                foreach ($arguments as $opertype=>$opers){
                    $opers=json_repair($opers);
                    if($opertype == 'operations'){
                        $oper_arr=['fgid'=>$fgid,'use_images'=>$use_images,'rid'=>fs($result,'id'),'sessionid'=>$sessionid,'mesid'=>fs($aimes,"id")];
                        foreach ($opers as $oper_key=>$oper){
                            $oper=json_repair($oper);
                            $where_stop=fs($_REQUEST,'test')?'':'';
                            if($where_stop===$oper_key){
                                $block_next_stages=1;
                                pr('NEXT:--------------------------------');
                                pr(fs($opers,$oper_key+1));
                                pr('OPER:--------------------------------');
                                pr($oper);
                            }
                            aih('operate',$oper_arr+['oper'=>$oper,'oper_key'=>$oper_key]);
                            if(is_numeric($where_stop)&&$oper_key==$where_stop){
                                die('jjj');
                            }
                        }
                    }
                    if($opertype=='connections'){
                        $fg=fs(fg('get',['id'=>$fgid,'force'=>1]),0);
                        $fg_prms=fs($fg,'params');
                        $drawflow=fs($fg_prms,'drawflow_main');
                        foreach ($opers as $oper_key=>$cnct){
                            pr('CONNECT:--------------------------------');
                            pr($cnct);
                            $from_node=fs($cnct,'from_node');
                            if(!is_numeric($from_node)){
                                $from_node=fs($operate_map,$from_node);
                            }
                            $from_elem=fs(elem('get',['id'=>$from_node,'force'=>1]),0);
                            $from_elem_prms=fs($from_elem,'params');
                            $from_elem_role=fs($from_elem_prms,'stgs_role');
                            $from_elem_role_obj=fs($stgs_roles,$from_elem_role);
                            $nonext=fs($from_elem_role_obj,'nonext');
                            
                            $output_index=fs($cnct,'output_index');
                            $page_event=fs($cnct,'page_event');
                            $to_node=fs($cnct,'to_node');
                            if(!is_numeric($to_node)){
                                $to_node=fs($operate_map,$to_node);
                            }
                            if($output_index&&is_numeric($from_node)){
                                if($nonext&&$output_index==1){//fix for incorrect first node output
                                    $output_index=2;
                                }
                                if(is_numeric($to_node)){
                                    $drawflow=drawflow_connect($drawflow,$from_node,$to_node,'output_'.$output_index,'input_1');
                                } else {
                                    $drawflow=drawflow_disconnect($drawflow,$from_node,'outputs','output_'.$output_index);
                                }
                                sql('set',['id'=>$fgid,'k'=>'drawflow_main','value'=>$drawflow,'t'=>'fg','prms'=>1]);
                                //die('died();');
                            }
                            if($page_event){
                                $block_id=fs($page_event,'block_id');
                                if(!is_numeric($block_id)){
                                    $block_id=fs($operate_map,$block_id);
                                }
                                $elem=fs(elem('get',['id'=>$from_node,'force'=>1]),0);
                                $elem_prms=fs($elem,'params');
                                $pageid=fs($elem_prms,'pageid');
                                $elem_events=jf('elem_events',['funcid'=>$pageid,'fgid'=>$fgid]);
                                $count=1;
                                foreach (fs($elem_events,'map',[]) as $key => $value){
                                    if(fs($value,'action')==fs($page_event,'event')&&fs($value,'elemid')==$block_id){
                                        pr('found to connect!!!!');
                                        pr('from_node:'.$from_node.':to_node:'.$to_node.':output_'.$count.':input_1');
                                        if(is_numeric($to_node)){
                                            $drawflow=drawflow_connect($drawflow,$from_node,$to_node,'output_'.$count,'input_1');
                                        } else {
                                            $drawflow=drawflow_disconnect($drawflow,$from_node,'outputs','output_'.$count);
                                        }
                                        sql('set',['id'=>$fgid,'k'=>'drawflow_main','value'=>$drawflow,'t'=>'fg','prms'=>1]);
                                    }
                                    $count++;
                                }
                            }
                        }
                        sql('set',['id'=>$fgid,'k'=>'drawflow_self_connected','v'=>1,'t'=>'fg','prms'=>1]);
                    }
                    jf('php_join',['fgid'=>$fgid]);
                    if($opertype=='settings'){

                    }
                }
                pr('operate map:');
                pr($operate_map);
                pr('stgs:');
                $stgs=jf('stgs',['fgid'=>$fgid,'force'=>1]);
                pr($stgs);
                //pr($sys);
                //pr($tools);

                //pr($arguments);
                //die('ssskks');
                //pr($result);
                //die('died();');
                /*
                
                */
                if(fs($_REQUEST,'state')){
                    die('stop further code we are testing;');
                }
                if(!$block_next_stages){
                    $run_again=1;
                    if($is_new_funnel){
                        sql('set',['id'=>$taskid,'k'=>'stage_done_'.$stage_index,'v'=>date('Y-m-d H:i:s'),'t'=>'aih_ent','prms'=>1]);
                    } else {
                        sql('set',['id'=>$taskid,'k'=>'edit_done_'.$edit_index,'v'=>date('Y-m-d H:i:s'),'t'=>'aih_ent','prms'=>1]);
                    }
                }
                sql('set',['id'=>$fgid,'k'=>'aih_working','remove'=>1,'t'=>'func_group','prms'=>1]);
                //die('died2();');
            }
            $noanswer=1;
    /*

            pr('>>>>>PROMPT<<<<<');
            pr($ai_arr);*/
        }

        //------------------------------------------------------------------------------------
        $state='finish';
        $states[$state]=[];
        if($slug=='finish'){
            $fgid=fs($data_fast,'fgid');
            $taskid=fs($data_fast,'taskid');
            $task_prms=fs(fs($data_fast,'task'),'params');
            $task_content=fs($task_prms,'content');
            $sys='';
            //$noprevconv=1;
            $task_opened=fs($conversation,'task_opened');
            $what_done=[];
            foreach ($messages as $key => $message) {
                if(fs($message,'id')>=fs($task_opened,'id')){
                    $message_prms=fs($message,'params');
                    $result=fs($message_prms,'result');
                    $tool_calls=fs(fs(fs($result,'tool_calls'),0),'function',[]);
                    if(fs($tool_calls,'name')=='edit_funnel'){
                        $what_done[]=fs($tool_calls,'arguments');
                    }
                }
            }
            $what_done['task_content']=$task_content;
            $sys .= '<result>' . json_encode($what_done, JSON_UNESCAPED_UNICODE) . '</result>';

            $sys .= 'The funnel editing process is now complete.' . "\n";
            $sys .= 'Summarize what was done in ONE short paragraph using simple, non-technical language that any user can understand.' . "\n";
            $sys .= 'Do NOT list individual technical changes, field names, IDs, or JSON data.' . "\n";
            $sys .= 'Do NOT Include any link. It will be added after your message automatically'."\n";
            $sys .= 'Strictly use the same language as the user uses.'."\n";
            $sys .= 'Do NOT describe the <result> structure or its contents directly.' . "\n";
            $sys .= 'Instead, briefly explain the overall outcome — what changed in the funnel from the user\'s perspective.' . "\n";

            if($result){
                sql('set',['id'=>$taskid,'k'=>'taskclose','v'=>1,'t'=>'aih_ent','prms'=>1]);
            }
        }


        if($filter){
            if(in_array('visible_on_init',$filter)){
                $temp_ar=[];
                foreach($states as $key=>$state){
                    if(fs($state,'visible_on_init')){
                        $temp_ar[$key]=$state;
                    }
                }
                $states=$temp_ar;
            }
        }
        if($response_format){
            $noanswer=1;
        }
        $res=[
            'model'=>$model,
            'noprevconv'=>$noprevconv,
            'reasoning_effort'=>$reasoning_effort,
            'noanswer'=>$noanswer,
            'run_again'=>$run_again,
            'thinking'=>$thinking,
            'sys'=>$sys,
            'presys'=>$presys,
            'tools'=>$tools,'states'=>$states,'slug'=>$slug,
            'ai_json'=>$ai_json,'tool_choice'=>$tool_choice,
            'response_format'=>$response_format,
            'hidden_slug'=>$hidden_slug_prefix.$slug.$hidden_slug_suffix];
        return $res;
    }
    if($act=='operate'){
        $fgid=$stage=$stsg_role=$elem_type=$elem=$use_images=$stage_id=$parent_type=$elem_arch=$rid=$oper=$manual_update=$oper_key=$sessionid=$mesid='';
        global $operate_map;
        global $operate_sort;
        $operate_map=$operate_map??[];
        extract($arr);
        $log=fs($_REQUEST,'test');
        if($log){
            //pr('OPER:--------------------------------');
            //pr($oper);
        }
        pr('OPER:--------------------------------');
        pr($oper);
        
        $fg=fs(fg('get',['id'=>$fgid,'force'=>1]),0);
        $stgs_roles=jf('stgs_roles',['fgid'=>$fgid]);
        $fg_prms=fs($fg,'params');
        $entity=fs($oper,'entity');
        $action=fs($oper,'action');
        $stage_id=fs($oper,'stage_id');
        $parent_id=fs($oper,'parent_id');
        $parent_type=fs($oper,'parent_type','page');
        $slug=fs($oper,'slug');
        $role=fs($oper,'role');
        $id=fs($oper,'id');
        $node_type=fs($oper,'node_type');
        $block_type=fs($oper,'block_type');
        $slide_id=fs($oper,'slide_id');
        if($entity=='stage'||$stage_id){
            $stgs=jf('stgs',['fgid'=>$fgid,'force'=>1]);
        }


        $nodes_all=atm('nodes',['fgid'=>$fgid]);
        $elems_all=elem('all',['aih'=>1]);
        $elems_all_slug=array_combine(array_column($elems_all,'slug'),array_keys($elems_all));

        $rids=substr($rid,0,10);
        
        $slg='s:'.$sessionid.':m:'.$mesid.':'.$rids.':'.$oper_key;
        $prms=json_repair(fs($oper,'params',[]));
        $is_first=fs($stage,'first');
        
        if($parent_id){
            if(!is_numeric($parent_id)){
                $parent_id=fs($operate_map,$parent_id);
            }
        }
        if($slide_id){
            if(!is_numeric($slide_id)){
                $slide_id=fs($operate_map,$slide_id);
            }
        }
        if($stage_id){
            if(!fs($stgs,$stage_id)){
                $stage_id=fs($operate_map,$stage_id);
            }
        }
        //define elem
        if($id){
            if($entity=='block'||$entity=='node'){
                $elem=fs(elem('get',['id'=>$id,'force'=>1]),0);
            }
        } else if($action=='create'){
            if($entity=='block'){
                $elem_type=fs($elems_all_slug,$block_type);
                $elem=fs(elem('get',['slg'=>$slg,'jfid'=>$fgid,'force'=>1]),0);
                if(!$elem){
                    $id=elem('create',['slg'=>$slg,'jfid'=>$fgid]);
                    $elem=fs(elem('get',['id'=>$id,'force'=>1]),0);
                }
                $id=fs($elem,'id');
            }
            if($entity=='node'){
                $elem_type=$node_type;
                if(!$elem_type&&$role){
                    $elem_type=fs(fs($stgs_roles,$role),'default_node');
                }
                $prms['stgs_id']=$stage_id;
                $prms['stgs_role']=$role;
                $elem=fs(elem('get',['slg'=>$slg,'jfid'=>$fgid,'force'=>1]),0);
                $flow_add=jf('flow_add',['fgid'=>$fgid,'slg'=>$slg,'jfid'=>$fgid,'elemid'=>fs($elem,'id'),'stgs_role'=>$role,'drawflow'=>1,'stgs_id'=>$stage_id,'type'=>$elem_type]);
                $id=fs($flow_add,'id');
            }
            if($entity=='block'||$entity=='node'){
                sql('set',['id'=>$id,'k'=>'type','v'=>$elem_type,'t'=>'func_elems']);
                $elem=fs(elem('get',['id'=>$id,'force'=>1]),0);
            }
            if($entity=='pricing_plan'){
                $plan_mod=product('plan_mod');
                $modid=fs($plan_mod,'modid');
                $first_mod_id=fs($plan_mod,'first_mod_id');
                $func=fs(func('get',['jfid'=>$fgid,'slg'=>$slg,'force'=>1]),0);
                if(!$func){
                    $funcid=product("mod",["type"=>"create",'jfid'=>$fgid,'slg'=>$slg,'name'=>fs($prms,'name'),"ptype"=>"plan","parent"=>$first_mod_id,"fgid"=>$modid]);
                    $func=fs(func('get',['id'=>$funcid,'force'=>1]),0);
                }
                $id=fs($func,'id');
            }
            if($entity=='variable'){
                $name=fs($prms,'name');
                $pr=$prms;
                unset($pr['name']);
                $id=fs(vr('create',['name'=>$name,'safe_name'=>1,'params'=>$prms,'import_hash'=>$slg]),'id');
            }
            if($entity=='stage'){
                $id=jf('stgs_act',['fgid'=>$fgid,'slug'=>$slug,'name'=>fs($prms,'name'),'params'=>['by_ai'=>1],'t'=>'add']);
            }
            if($entity=='quiz_slide'){
                $parent=fs(elem('get',['id'=>$parent_id,'force'=>1]),0);
                $parent_prms=fs($parent,'params');
                $qzid=fs($parent_prms,'qzid');
                if(!$qzid){
                    return ['error'=>'QZ not found'];
                }
                $add_slide=qz('add_slide',['qzid'=>$qzid,'slg'=>$slg]);
                $id=fs($add_slide,'id');
            }
            $manual_update=[1];
            if($slug){
                $operate_map[$slug]=$id;
            }
        }
        //add to slide
        if($oper_key==14){
            /*
            pr($slide_elems);
            die('sss');
            pr($slide_id);*/
        }


        if($elem){
            //define page
            $elem_prms=fs($elem,'params');
            $stsg_role=fs($elem_prms,'stgs_role');
            $elem_type=fs($elem,'type');
            if($elem_type=='page'){
                $pageid=fs($elem_prms,'pageid');
                if(!$pageid){
                    $page_default_fill=jf('page_default_fill',['fgid'=>$fgid,'elemid'=>$id,'noelems'=>1]);
                    $page_id=fs($page_default_fill,'id');
                }
                $page=fs(func('get',['id'=>$pageid,'force'=>1]),0);
                $page_prms=fs($page,'params');
                $elems=fs($page_prms,'elems');
            }
            if($elem_type=='qz'){
                $qzid=fs($elem_prms,'qzid');
                if(!$qzid){
                    $qzname=fs($fg,'name').': '.fs($stage,'name');
                    $qzid=qz('create',['name'=>$qzname,'elemid'=>$id,'params'=>['demo_content'=>1]]);
                    $elem_prms['qzid']=$qzid;
                }
            }
        }



        //reoder
        $insert_after=fs($oper,'insert_after');
        $insert_before=fs($oper,'insert_before');
        $insert_at=fs($oper, 'insert_at');
        if($action=='create'||$insert_after||$insert_before||$insert_at){
            if($entity=='block'){
                if($parent_type=='page'){
                    $parent_node=fs(elem('get', ['id'=>$parent_id,'force'=>1]), 0);
                    $pageid=fs(fs($parent_node, 'params'), 'pageid');
                    $parent_page=fs(func('get', ['id'=>$pageid, 'force'=>1]), 0);
                    $parent_elems_o=fs($parent_page, 'elems');
                    $parent_elems=array_filter(explode(',', $parent_elems_o));
                    $parent_elems=aih('reorder_insert',['list'=>$parent_elems,'id'=>$id,'oper'=>$oper,'operate_map'=>$operate_map]);
        
                    if($parent_elems_o!=implode(',', $parent_elems)) {
                        sql('set',['id'=>$pageid,'k'=>'elems','v'=>implode(',',$parent_elems),'t'=>'func']);
                    }
                    sql('set',['id'=>$id, 'k'=>'func', 'v'=>$pageid, 't'=>'func_elems', 'prms'=>1]);
                }
            }
            if($entity=='stage') {
                $fg=fs(fg('get', ['id'=>$fgid, 'force'=>1]), 0);
                $fg_prms=fs($fg, 'params');
                $stgs_order_o=fs($fg_prms,'stgs_order');
                $stgs_order=array_filter(explode(',', $stgs_order_o));
                $stgs_order=aih('reorder_insert',['list'=>$stgs_order,'id'=>$id,'oper'=>$oper,'operate_map'=>$operate_map]);
        
                if($stgs_order_o!=implode(',',$stgs_order)) {
                    sql('set',['id'=>$fgid,'k'=>'stgs_order','v'=>implode(',',$stgs_order),'t'=>'func_group', 'prms'=>1]);
                }
            }
            if($slide_id&&$parent_type=='quiz_slide'){
                $slide=fs(func('get',['id'=>$slide_id,'force'=>1]),0);
                $qzid=fs(fs($slide,'params'),'qzid');
                $slide_elems_o=fs($slide,'elems');
                $slide_elems=array_filter(explode(',',$slide_elems_o));
                $slide_elems=aih('reorder_insert',['list'=>$slide_elems,'id'=>$id,'oper'=>$oper,'operate_map'=>$operate_map]);

                if($slide_elems_o!=implode(',',$slide_elems)){
                    sql('set',['id'=>$slide_id,'k'=>'elems','v'=>implode(',',$slide_elems),'t'=>'func']);
                }
                qz('build_map',['qzid'=>$qzid]);
            }
            if($entity=='quiz_slide'){
                $parent=($parent?$parent:fs(elem('get',['id'=>$parent_id,'force'=>1]),0));
                $parent_prms=fs($parent,'params');
                $qzid=fs($parent_prms,'qzid');
                $qz=fs(qz('get',['id'=>$qzid,'force'=>1]),0);
                $qz_prms=fs($qz,'params');
                $order_o=fs($qz_prms,'order');
                $order=array_filter(explode(',',$order_o));
                $order=aih('reorder_insert',['list'=>$order,'id'=>$id,'oper'=>$oper,'operate_map'=>$operate_map]);
                if($order_o!=implode(',',$order)){
                    sql('set',['id'=>$qzid,'k'=>'order','v'=>implode(',',$order),'t'=>'func','prms'=>1]);
                }
                qz('build_map',['qzid'=>$qzid]);
            }
        }
        //set parent
        if($parent_id&&$parent_type=='page'){
            //sql('set',['id'=>$id,'k'=>'func','v'=>$parent_id,'t'=>'func_elems']);
        }
        if($action=='delete'){
            if($entity=='block'){
                elem('remove',['id'=>$id]);
            }
            if($entity=='quiz_slide'){
                qz('remove_slide',['id'=>$id]);
            }
            if($entity=='stage'){
                jf('stgs_act',['fgid'=>$fgid,'t'=>'remove','stgs_id'=>$id]);
            }
        }
        if($action=='update'||$manual_update){
            $default_porperties=fs(elem('arch',['type'=>'btne','default'=>1,'fgid'=>$fgid]),'default');
            if($entity=='block'||$entity=='node'){
                if($slug=='crm_set_ig'){
                    pr('??????');
                    pr($elem_prms);
                }
                $strs_role=fs($elem_prms,'stgs_role');
                $only_elem_prms=['stgs_id','stgs_role'];
                $vr_checks=['vr','vr_set_vrid','vr_img'];
                $txt_to_tinymce=['tnote'=>['tnote']];
                //video
                if($elem_type=='video1'){
                    $prms['s_fw']=1;
                }
                if($elem_type=='picg'&&fs($elem_prms,'img_prompt_orient')=='16:9'){
                    $prms['s_fw']=1;
                    //pr('die');
                    //die('llll');
                }
                foreach ($prms as $pkey=>$pvalue){
                    //add s uinq
                    $uniq_s=[
                        'trigger'=>['triggers'],
                        'message'=>['bn'],
                        'fielde'=>['options'],
                    ];
                    if($pkey=='img'&&!$pvalue){
                        continue;
                    }
                    foreach ($uniq_s as $k=>$v){
                        if($elem_type==$k&&in_array($pkey,$v)&&is_array($pvalue)){
                            foreach ($pvalue as $k1=>$v1){
                                $pvalue[$k1]['s']=tokgen(3);
                            }
                        }
                    }
                    foreach ($txt_to_tinymce as $k=>$v) {
                        if($elem_type==$k&&in_array($pkey,$v)){
                            $pvalue='<p>'.str_replace("\n",'<br>',$pvalue).'</p>';
                        }
                    }
                    //trigger for first page
                    if($is_first&&$stsg_role=='trigger'&&$pkey=='triggers'&&is_array($pvalue)){
                        $start_trigger_found='';
                        foreach ($pvalue as $key=>$value) {
                            if(fs($value,'event')=='bot_ref_link'&&!$start_trigger_found){
                                $pvalue[$key]['bot_ref_link_link']='jf:'.$fgid;
                                $start_trigger_found=1;
                            }
                        }
                    }
                    if($elem_type=='trigger'){
                        if($pkey=='triggers'&&is_array($pvalue)){
                            foreach ($pvalue as $key => $value) {
                                $payment_planid=fs($value,'payment_planid');
                                if($payment_planid&&!is_numeric($payment_planid)){
                                    $payment_planid=fs($operate_map,$payment_planid);
                                    $pvalue[$key]['payment_planid']=$payment_planid;
                                }
                            }
                        }
                    }
                    if($elem_type=='plan'){
                        if($pkey=='planid'){
                            if(!is_numeric($pvalue)){
                                $pvalue=fs($operate_map,$pvalue);
                            }
                        }
                    }
                    if($elem_type=='message'&&$pkey=='mes'){
                        $pvalue=preg_replace('/<p>\s*(&nbsp;|\xC2\xA0|\s)*<\/p>/iu', '', $pvalue);
                        $pvalue=preg_replace('/(<\/p>)\s+(<p>)/i', '$1$2', $pvalue);
                        $pvalue=str_replace(['</p>'."\n\n".'<p>','</p>'."\n".'<p>','</p><p>'],'</p>'."\n".'<p>&nbsp;</p>'."\n".'<p>',$pvalue);
                    }
                    //icons set
                    if($elem_type=='icns'&&$pkey=='icns'){
                        foreach ($pvalue as $key=>$value) {
                            $t=fs($value,'t');
                            $d=fs($value,'d');
                            if($t==strip_tags($t)){
                                $t='<p>'.$t.'</p>';
                            }
                            if($d==strip_tags($d)){
                                $d='<p>'.$d.'</p>';
                            }
                            $pvalue[$key]['t']=$t;
                            $pvalue[$key]['d']=$d;
                        }
                    }
                    //remove unnecessary fields
                    if(strp('follow',$strs_role)&&$pkey=='delay_h'){
                        sql('set',['id'=>$id,'k'=>$pkey,'remove'=>1,'t'=>'func_elems','prms'=>1]);
                        continue;
                    }
                    if($id==46819){
                        //pr($elem); 
                    }
                    if(!$use_images&&$pkey=='img_prompt'){
                        continue;
                    }
                    if(in_array($pkey,$vr_checks)){
                        
                        if(!is_numeric($pvalue)){
                            $pvalue=fs($operate_map,$pvalue);
                        }
                    }
                    if($elem_type=='page'&&!in_array($pkey,$only_elem_prms)){
                        sql('set',['id'=>$pageid,'k'=>$pkey,'v'=>$pvalue,'t'=>'func','prms'=>1]);
                    } else if($elem_type=='qz'&&!fs($default_porperties,$pkey)){
                        $qzid=fs($elem_prms,'qzid');
                        sql('set',['id'=>$qzid,'k'=>$pkey,'v'=>$pvalue,'t'=>'func','prms'=>1]);
                    } else {
                        $elem_prms[$pkey]=$pvalue;
                        sql('set',['id'=>$id,'k'=>$pkey,'v'=>$pvalue,'t'=>'func_elems','prms'=>1]);
                    }
                }
                //picg
                if($elem_type=='picg'&&fs($elem_prms,'entron')){
                    $elem_prms['img_prompt_orient']='4:5';
                    sql('set',['id'=>$id,'k'=>'img_prompt_orient','v'=>'4:5','t'=>'func_elems','prms'=>1]);
                }
                //messages
                if($stsg_role=='init'||strp('follow',$stsg_role)){
                    sql('set',['id'=>$id,'k'=>'img_prompt_orient','v'=>'1:1','t'=>'func_elems','prms'=>1]);
                }
                if(strp('follow',$stsg_role)){
                    sql('set',['id'=>$id,'k'=>'img_prompt_resolution','v'=>'0.5K','t'=>'func_elems','prms'=>1]);
                }
                aih('img_prompt',['elemid'=>$id,'','prms'=>$elem_prms]);
            }
            if($entity=='node'&&$action=='create'){
                $stgs=jf('stgs',['fgid'=>$fgid,'force'=>1,'show_elems'=>1]);
            }
            if($entity=='pricing_plan'){
                foreach ($prms as $pkey=>$pvalue){
                    if($pkey=='name'){
                        sql('set',['id'=>$id,'k'=>$pkey,'v'=>$pvalue,'t'=>'func']);
                    } else {
                        sql('set',['id'=>$id,'k'=>$pkey,'v'=>$pvalue,'t'=>'func','prms'=>1]);
                    }
                }
            }
            if($entity=='quiz_slide'){
                foreach ($prms as $pkey=>$pvalue){
                    sql('set',['id'=>$id,'k'=>$pkey,'v'=>$pvalue,'t'=>'func_elems','prms'=>1]);
                }
            }
        }
    }
    if($act=='download_jf_ai'){
        $fgid=$u='';
        extract($arr);
        $arch_pl=aih('arch_pl',['fgid'=>$fgid,'noelems'=>1]);
        $arch_fg=aih('arch_fg',['fgid'=>$fgid]);

        $fg=fs(fg('get',['id'=>$fgid]),0);
        $fg_prms=fs($fg,'params');
        $build=fs($fg_prms,'build');
    
        $system=<<<'PROMPT'
    You are a professional funnel strategist and marketing analyst. Your job is to produce a beautifully formatted Markdown document that serves as a complete analysis and walkthrough of a client's sales funnel.
    
    <purpose>
    The reader is a business owner who built this funnel on our platform. They are downloading this document as a PDF to understand their funnel structure, remember what each stage does, and appreciate the value of having an automated funnel. Some readers may be leaving the platform — this document should remind them why the funnel they built is powerful and worth keeping active.
    </purpose>
    
    <critical_rules>
    
    RULE 1 — NO TECHNICAL LANGUAGE:
    The reader is NOT a technical person. NEVER include in the output:
    - Node IDs, block IDs, stage IDs, or any internal identifiers (like "47456", "gf5", "r42")
    - Property names, JSON keys, or code terms (like "role_init", "stage_next", "tochatbot", "b_act", "bn", "t=image")
    - Variable syntax like {variable_name} — instead describe what personalization happens in plain words (e.g., "the message greets the client by their first name")
    - Any mention of "nodes", "triggers", "outputs", "connections", or platform architecture
    - Write as if explaining to someone who has never seen the backend. They only know their funnel from the client's perspective.
    
    RULE 2 — COVER IMAGE FIRST:
    The VERY FIRST line of the document must be a media shortcode [media id="..."] using the first image ID from the <media_ids> list. No text before it. The title comes after.
    
    RULE 3 — USE ALL IMAGES FROM <media_ids>:
    You will receive a <media_ids> tag containing a JSON array of all image IDs used in the funnel. You MUST use EVERY single ID from this list exactly once as [media id="ID"] somewhere in the document. Do not invent IDs. Do not skip any. Spread them throughout the document near relevant content sections.
    
    RULE 4 — DO NOT REPEAT FUNNEL TEXTS VERBATIM:
    The document will be followed by an appendix area (added separately) that contains all original funnel texts. Therefore:
    - NEVER copy or quote messages, page texts, button labels, or any funnel copy word-for-word
    - Instead, write a SHORT summary of what each message/page communicates and what goal it serves
    - Example: Instead of quoting a follow-up message, write: "The first follow-up reminds the client about success stories of other partners and encourages them to watch the video"
    
    RULE 5 — DESCRIBE WHAT'S ON EACH PAGE:
    When a stage has a page (website), provide a compact bullet list of what content blocks are on that page. Describe them in human terms:
    - ✅ "Hero image with a call-to-action button"
    - ✅ "Video lesson about partner case studies"
    - ✅ "4-step questionnaire collecting business niche, pain points, marketing challenges, and AI usage"
    - ✅ "Pricing plan block with trial period details"
    - ✅ "FAQ section with 12 questions about the platform"
    - ❌ NOT: "block type=video with params s_fw=1" or "quiz block id=47534"
    
    RULE 6 — NO BIG PARAGRAPHS:
    Maximum 2-3 sentences per paragraph. Prefer:
    - **Bold key phrases** to guide the eye
    - Bullet lists and numbered lists for any set of items
    - > Blockquotes for key insights or strategic takeaways
    - Short punchy sentences over long explanations
    - Emoji as visual markers (sparingly, for section starts and list items)
    - Horizontal rules (---) between major sections
    - Varied formatting — never have more than 3 consecutive plain-text lines without some formatting element
    
    </critical_rules>
    
    <output_format>
    FORMAT: Output ONLY raw Markdown. No code fences wrapping the entire output. No preamble. Start directly with the cover image shortcode.
    
    LANGUAGE: Write in the SAME language as the funnel content. If funnel stages and messages are in Russian — write in Russian. Match exactly.
    
    LENGTH: 1500-4000 words depending on funnel complexity. Keep it scannable.
    </output_format>
    
    <document_structure>
    
    # SECTION 1: COVER
    - Line 1: [media id="FIRST_ID_FROM_MEDIA_IDS"] — no text before this
    - Line 2: Funnel name as # heading
    - Line 3: A short inspiring subtitle (1 sentence)
    
    ---
    
    # SECTION 2: EXECUTIVE SUMMARY
    - 3-5 bullet points answering:
      - What type of funnel is this?
      - Who is it for?
      - How many stages and what's the journey?
      - What's the final goal?
    - End with a blockquote: a key strategic insight about why this funnel works
    
    ---
    
    # SECTION 3: FUNNEL MAP
    A numbered visual overview. Format each line as:
    **[Number]** [Emoji] **Stage Name** — Key action in one sentence
    
    This gives the reader a bird's-eye view before diving into details.
    
    ---
    
    # SECTION 4: STAGE-BY-STAGE BREAKDOWN
    For EACH stage, produce:
    
    ## [Emoji] Stage [N]: [Stage Name]
    
    **🎯 Key Action:** One sentence — what must the client do here?
    
    **Why this stage matters:**
    > A 1-2 sentence blockquote with the strategic reasoning
    
    **What's on the page** (only if stage has a page):
    A bullet list describing each content element the client sees. Keep each bullet to one line. Group related items. Mention:
    - Images and their purpose
    - Videos and their topic
    - Text sections and their message (summarized)
    - Forms/questionnaires — what info is collected and why
    - Buttons — where they lead (in human terms)
    - Pricing plans — price, trial, billing
    - FAQ sections — how many questions, general topics covered
    - Any special elements (countdown timers, social proof, partner blocks, etc.)
    
    [media id="..."] — place relevant image here
    
    **Chat messages the client receives:**
    A compact list:
    - **Welcome message:** 1 sentence summary of what it says and its emotional angle
    - **Follow-up 1** (after ~1 hour): 1 sentence summary and persuasion angle
    - **Follow-up 2** (after ~2 hours): 1 sentence summary and persuasion angle  
    - **Follow-up 3** (after ~23 hours): 1 sentence summary and persuasion angle
    
    [media id="..."] — place message images here if any
    
    **➡️ What moves the client forward:** One sentence — what triggers advancement (e.g., "Completing the questionnaire and clicking the button on the final slide")
    
    ---
    
    # SECTION 5: FOLLOW-UP STRATEGY OVERVIEW
    - Short explanation (3-5 bullets) of how automatic follow-ups work across the funnel
    - Mention the timing pattern
    - Why multi-touch messaging increases conversion
    
    > A blockquote with a key insight about follow-up effectiveness
    
    ---
    
    # SECTION 6: PERSONALIZATION
    - Bullet list of what personal data is collected throughout the funnel
    - How it's used (e.g., "greets by name", "references their business niche in messages")
    - Keep it simple — no variable names, just describe what happens from the client's perspective
    
    ---
    
    # SECTION 7: PRICING & MONETIZATION (only if pricing plans exist)
    - Plan name, price, trial period, billing cycle — in a clean formatted block
    - Where in the journey the offer appears
    - What happens after purchase
    
    ---
    
    # SECTION 8: CLOSING
    - 2-3 short paragraphs (2 sentences max each)
    - Remind the owner: this funnel works 24/7 automatically
    - Emphasize the value: follows up, personalizes, guides clients step by step
    - End with a bold memorable one-liner
    
    </document_structure>
    
    <image_placement_strategy>
    You receive all available image IDs in <media_ids>. Distribute them as follows:
    1. First ID → cover (before title)
    2. Remaining IDs → spread across stage sections, placing each near the content it relates to
    3. If a stage has multiple images, place them at different points within that stage's section (not clustered together)
    4. Add a brief italic caption line after each image shortcode describing what the image shows (based on your understanding of the context)
    5. Every ID from <media_ids> must appear exactly once
    </image_placement_strategy>
    
    <quality_checklist>
    Before finishing, verify:
    - [ ] First line is [media id="..."] — no text before it
    - [ ] ALL IDs from <media_ids> are used exactly once
    - [ ] Zero technical terms, IDs, node names, or code syntax in the text
    - [ ] No funnel text is quoted verbatim — only summaries
    - [ ] Every stage with a page has a bullet list of page contents
    - [ ] No paragraph exceeds 3 sentences
    - [ ] Document language matches funnel content language
    - [ ] Formatting is varied: bold, lists, blockquotes, emoji markers, horizontal rules
    - [ ] Closing section is inspiring and encourages keeping the funnel active
    </quality_checklist>
    PROMPT;
    
    $img_list=jf('img_list',['fgid'=>$fgid]);
        $u='<funnel_platform_context>'.json_encode($arch_pl,JSON_UNESCAPED_UNICODE).'</funnel_platform_context>'."\n";
        $u.='<funnel_current_state>'.json_encode($arch_fg,JSON_UNESCAPED_UNICODE).'</funnel_current_state>'."\n";
        $u.='<media_ids>'.json_encode($img_list,JSON_UNESCAPED_UNICODE).'</media_ids>'."\n";
        $u.='Analyze this funnel from "<funnel_current_state>" and produce the Markdown document following all instructions from your system prompt. Start directly with the title — no preamble.';
        $ai_arr=[
            'model'=>'clds',
            'max_tokens'=>54000,
            'messages'=>[
                [
                    'r'=>'s',
                    'c'=>$system,
                    'cache'=>1,
                ],
                [
                    'r'=>'u',
                    'c'=>$u,
                ]
            ]
        ];
        $funcid=fs($build,'download_jf_ai');
        $r=ai('send',$ai_arr);
        $content=fs($r,'content');
        if($content){
            sql('set',['id'=>$funcid,'k'=>'content','v'=>$content,'t'=>'func','prms'=>1]);
        }
        return $r;
    }
    if($act=='download_jf'){
        $fgid='';
        extract($arr);
        $img_list=jf('img_list',['fgid'=>$fgid]);
        $medias=media('get',['ids'=>$img_list]);
        $urls=[];
        foreach ($medias as $key => $value) {
            if(fs(explode('?',fs($value,'url')),0)){
                $urls[]=$global_domain.fs(explode('?',fs($value,'url')),0);
            }
        }
        $zip_path=$path . '/crm/php/rare/temper/' . tokgen() . '.zip';
        $zip=new ZipArchive();
        if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($urls as $index => $url) {
                // Fetch image content from URL
                $img_content=@file_get_contents($url);
                if ($img_content !== false) {
                    // Extract filename from URL, fallback to index-based name
                    $filename=basename(parse_url($url, PHP_URL_PATH));
                    if (empty($filename) || !pathinfo($filename, PATHINFO_EXTENSION)) {
                        $filename='image_' . ($index + 1) . '.jpg';
                    }
                    $zip->addFromString($filename, $img_content);
                }
            }
            $zip->close();
            if (file_exists($zip_path)) {
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="images_' . date('Ymd_His') . '.zip"');
                header('Content-Length: ' . filesize($zip_path));
                header('Pragma: no-cache');
                readfile($zip_path);
                unlink($zip_path);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Failed to create ZIP file']);
            exit;
        }
        return ['url'=>$zip_path];
    }
    if($act=='reorder_insert'){
        $list=$id=$oper=$operate_map='';
        extract($arr);
        $insert_after=fs($oper, 'insert_after');
        $insert_before=fs($oper, 'insert_before');
        $insert_at=fs($oper, 'insert_at');
        if (in_array($id,$list)) return $list;
        if ($insert_after) {
            if (!is_numeric($insert_after)) $insert_after=fs($operate_map, $insert_after);
            $pos=array_search($insert_after, $list);
            if ($pos !== false) {
                array_splice($list, $pos + 1, 0, [$id]);
                return $list;
            }
        }
        if ($insert_before) {
            if (!is_numeric($insert_before)) $insert_before=fs($operate_map, $insert_before);
            $pos=array_search($insert_before, $list);
            if ($pos !== false) {
                array_splice($list, $pos, 0, [$id]);
                return $list;
            }
        }
        if ($insert_at == 'start') {
            array_unshift($list, $id);
            return $list;
        }
        // Default: append to end
        $list[]=$id;
        return $list;

    }
    if($act=='img_prompt'){
        $elemid=$generate=$prms='';
        extract($arr);
        if(!$prms){
            $elem=fs(elem('get',['id'=>$elemid,'force'=>1]),0);
            $prms=fs($elem,'params');
        }
        $img_prompt=fs($prms,'img_prompt');
        if(!$img_prompt){
            return;
        }
        $img_prompt_media_ids=fs($prms,'img_prompt_media_ids');
        $img_prompt_orient=fs($prms,'img_prompt_orient','1:1');
        $img_prompt_resolution=fs($prms,'img_prompt_resolution','1K');
        //delete
        if($img_prompt_orient==8){
            $img_prompt_orient='1:1';
        }
        $md5=md5(strip_tags(sr($img_prompt.'|'.$img_prompt_media_ids.'|'.$img_prompt_orient,['"',"'",'\\'],'')));
        $img_prompt_md5=fs($prms,'img_prompt_md5');
        $img_prompt_last=fs($prms,'img_prompt_last');
        if($generate){
            $medias=media('get',['ids'=>$img_prompt_media_ids]);
            $temp=[];
            foreach ($medias as $key=>$value) {
                $url=fs($value,'url');
                if($url){
                    $temp[]=$global_domain.$url;
                }
            }
            $img_prompt_media=$temp;
            if($img_prompt_last&&$img_prompt_last>time()-60*3||$img_prompt_md5==$md5){
                return;
            }
            sql('set',['id'=>$elemid,'k'=>'img_prompt_last','v'=>time(),'t'=>'func_elems','prms'=>1]);
            $ai_arr=[
                'model'=>($test_ai?'gmnimg':'gmnimgl'),
                'messages'=>[
                    [
                        'r'=>'u',
                        'c'=>txt_d($img_prompt),
                    ]
                ]
            ];
            if($img_prompt_media){
                $ai_arr['messages'][0]['img']=$img_prompt_media;
            }
            $ai_arr['model_setts']=[
                'aspectRatio'=>$img_prompt_orient,
                'imageSize'=>$img_prompt_resolution,
            ];
            ///
            bot('alert',['text'=>'pre_ai','cont'=>1]);
            $php='
            $r=$result;
            bot("alert",["text"=>"post_ai"]);
            pr($r);
            //$r=["inlineData"=>["data"=>file_get_contents($path."/tdlib.py"),"mimeType"=>"image/png"]];
            $inlineData=fs($r,"inlineData");
            if($inlineData){
                file_put_contents($path."/crm/content/auto/files_3_day_old/el'.$elemid.'.txt",$inlineData);
                //bot("alert",["text"=>"img_promp2"]);
                $mime=fs($inlineData,"mimeType","image/png");
                $b64data=fs($inlineData,"data");
                if($b64data){
                    //bot("alert",["text"=>"img_prompt3"]);
                    $temp_dest="/crm/php/rare/temper/".tokgen().".png";
                    $image_data=base64_decode($b64data);
                    file_put_contents($path.$temp_dest,$image_data);
                    $newMediaId=self_created_pic("img_prompt".time(),$path.$temp_dest,".png",1,1,["upload_folder"=>0]);
                    if($newMediaId){
                        sql("set",["id"=>"'.$elemid.'","k"=>"img","v"=>$newMediaId,"t"=>"func_elems","prms"=>1]);
                        sql("set",["id"=>"'.$elemid.'","k"=>"img_prompt_md5","v"=>"'.$md5.'","t"=>"func_elems","prms"=>1]);
                    }
                    sql("set",["id"=>"'.$elemid.'","k"=>"img_prompt_last","remove"=>1,"t"=>"func_elems","prms"=>1]);
                }
            }
            ';
            $ai_arr['php']=$php;
            $r=ai("send",$ai_arr);
            return;
        }
        if($img_prompt_md5!=$md5){
            $php='
            aih("img_prompt",["elemid"=>"'.$elemid.'","generate"=>1]);
            ';
            if(fs($_REQUEST,'noimg_prompt')){
                die('image is going to be added111111');
            }
            //eval($php);
            $cronid=cron('create',['php'=>$php,'first'=>1]);
            cron('callback',['time'=>0,'cronid'=>$cronid]);
            
            //$r=ai("send",$array);
        }
        //die('hi');
        
        
        
    }
    if($act=='run'){
        $sys=$answer=$sessionid=$from_run_again='';
        extract($arr);
        
        // ── GATE: acquire session lock ──
        $lock_id=aih('lock_session',['sessionid'=>$sessionid]);
        if(!$lock_id&&!fs($_REQUEST,'state')){
            j('run blocked by lock','ggg');
            return ['aih_wait'=>1,'test'=>'1'];
        }
        
        j('run!-----------------------','ggg');
        j(bugs(1),'ggg');
        
        $max_loops=25;
        $final_answer='';
        $final_wait=0;
        
        for($loop=0; $loop<$max_loops; $loop++){
            j('run loop '.$loop,'ggg');
            
            // ── 1. Evaluate current state ──
            $state=aih('state',['sessionid'=>$sessionid]);
            $state_slug=fs($state,'slug');
            $run_again=fs($state,'run_again');
            $noanswer=fs($state,'noanswer');
            
            // If state already transitioned (e.g. conditions met, moved to next sub-state)
            if($run_again){
                j('loop '.$loop.' run_again from state','ggg');
                continue;
            }
            
            $model=fs($state,'model');
            $sys=fs($state,'sys');
            $presys=fs($state,'presys');
            $thinking=fs($state,'thinking');
            $reasoning_effort=fs($state,'reasoning_effort');
            $noprevconv=fs($state,'noprevconv');
            $state_hidden_slug=fs($state,'hidden_slug',$state_slug);
            $ai_json=fs($state,'ai_json');
            $tools=fs($state,'tools');
            $tool_choice=fs($state,'tool_choice');
            $response_format=fs($state,'response_format');
            
            if($test_ai){
                $model='groks';
            }
            
            if(fs($_REQUEST,'test')){
                pr('state: '.$state_slug.' loop: '.$loop);
            }
            
            // ── 2. Build conversation context ──
            $conversation=aih('message',['t'=>'phase_add','noprevconv'=>$noprevconv,'presys'=>$presys,'text'=>$sys,'slug'=>$state_hidden_slug,'state'=>$state_slug,'sessionid'=>$sessionid]);
            $messages=fs($conversation,'messages',[]);
            $last_message=fs($messages,array_key_last($messages));
            $last_message_id=fs($last_message,'id');
            $last_message_prms=fs($last_message,'params');
            $last_user_message=fs($conversation,'last_user_message');
            $last_airesponse=fs($conversation,'last_airesponse');
            $use_last_ai_responce=(
                $last_message_id==fs($last_airesponse,'id')
                && !fs($last_message_prms,'log')
            );
            if(fs($_REQUEST,'state')){
                
            } else {
                if(fs($last_message_prms,'run_again')){// skip already-processed responses;
                    $use_last_ai_responce='';
                }
            }
            //zzzzz
            if(!$last_user_message){
                j('no user message, break','ggg');
                break;
            }
            // ── 3. Check if AI response already exists ──
            if($use_last_ai_responce && !fs($_REQUEST,'force')){
                $r=fs(fs($last_airesponse,'params'),'result');
                $aimes=$last_airesponse;
                $aimesid=fs($aimes,'id');
                
                j('reusing existing AI response '.$aimesid,'ggg');
                // ── 4. Process the AI response through state machine ──
                $state2=aih('state',['sessionid'=>$sessionid,'aimes'=>$aimes,'result'=>$r]);
                $run_again2=fs($state2,'run_again');
                $noanswer2=fs($state2,'noanswer');
                if(fs($_REQUEST,'state')){
                    die('stop further code we are testing2;');
                }
                
                if($run_again2){
                    sql('set',['id'=>$aimesid,'k'=>'run_again','v'=>1,'t'=>'aih_message','prms'=>1]);
                    j('loop '.$loop.' run_again after processing result','ggg');
                    continue;// loop back — state transitioned
                }
                
                $final_answer=fs($r,'content');
                if($final_answer && !$noanswer2){
                    aih('message',['t'=>'create','mesid'=>$aimesid,'params'=>['text'=>$final_answer],'state'=>$state_slug,'type'=>1,'sessionid'=>$sessionid]);
                }
                break;// done
                
            } else {
                // ── 5. Need to send AI request (async) ──
                $repeat=fs($last_message_prms,'repeat',0);
                $aih_wait_slug=$last_message_id.':'.soul('id').($repeat?':r'.$repeat:'');
                
                $ai_arr=[
                    'model'=>$model,
                    'max_tokens'=>54000,
                    'messages'=>fs($conversation,'ar'),
                    'json'=>$ai_json,
                    'slug'=>$aih_wait_slug,
                ];
                if($thinking){ $ai_arr['thinking']=$thinking; }
                if($reasoning_effort){ $ai_arr['reasoning_effort']=$reasoning_effort; }
                if($response_format){ $ai_arr['response_format']=$response_format; }
                if($tools){
                    $ai_arr['tools']=$tools;
                    $ai_arr['tool_choice']=$tool_choice;
                }
                
                $now=fs($_REQUEST,'now');
                $aih_wait_data=['time'=>time(),'slug'=>$aih_wait_slug];
                sql('set',['id'=>$last_message_id,'k'=>'aih_wait','v'=>$aih_wait_data,'t'=>'aih_message','prms'=>1]);
                
                if(fs($_REQUEST,'die')=='before'){
                    pr('die(); before'); pr($ai_arr); die();
                }
                
                // Build webhook callback PHP — simplified: just store result + re-run
                $safe_sessionid=intval($sessionid);
                $php='
                $r=$result;
                if(fs($r,"error")){
                    sql("set",["id"=>'.$safe_sessionid.',"k"=>"last_error","v"=>fs($r,"error"),"t"=>"aih_session","prms"=>1]);
                } else {
                    sql("set",["id"=>'.$safe_sessionid.',"k"=>"last_error","remove"=>1,"t"=>"aih_session","prms"=>1]);
                }
                $rid=fs($r,"id");
                j("AI RESPONSE:","ses_'.$safe_sessionid.'");
                j($r,"ses_'.$safe_sessionid.'");
                aih("message",["t"=>"create","params"=>["ai_result"=>1,"result"=>$r],"state"=>"'.$state_slug.'","rid"=>$rid,"type"=>1,"sessionid"=>"'.$safe_sessionid.'"]);
                sql("set",["id"=>"'.$last_message_id.'","k"=>"aih_wait_done","v"=>1,"t"=>"aih_message","prms"=>1]);
                sql("set",["id"=>"'.$safe_sessionid.'","k"=>"aih_wait","remove"=>1,"t"=>"aih_session","prms"=>1]);
                aih("run",["sessionid"=>"'.$safe_sessionid.'"]);
                ';
                
                if($now){
                    $result=ai('send',$ai_arr);
                    eval($php);
                    // After eval, the loop in the recursive run() handled everything
                    // We break here since eval already called run()
                    // Actually, let's not eval — let's handle inline for $now mode:
                    // (keeping backward compat for testing)
                    aih('unlock_session',['sessionid'=>$sessionid,'lock_id'=>$lock_id]);
                    return aih('run',['sessionid'=>$sessionid]);
                } else {
                    $ai_arr['php']=$php;
                    $r=ai('send',$ai_arr);
                    if(fs($r,'ok')){
                        sql('set',['id'=>$last_message_id,'k'=>'aih_wait','v'=>$aih_wait_data+['logid'=>fs($r,'id')],'t'=>'aih_message','prms'=>1]);
                    }
                }
                
                $final_wait=1;
                break;// async request sent, exit loop
            }
        }
        
        // ── RELEASE LOCK ──
        aih('unlock_session',['sessionid'=>$sessionid,'lock_id'=>$lock_id]);
        
        if($final_wait&&!fs($_REQUEST,'state')){
            return ['aih_wait'=>1,'test'=>'2'];
        }
        
        $res=['answer'=>$final_answer];
        j('run complete','ggg');
        return $res;
    }
    
    if($act=='filterBySchema'){
        $schema=$params='';
        extract($arr);
        if(fs($params,'hide_show_mes')=='<p>'.jf('you_cant_see_yet').'</p>'){
            unset($params['hide_show_mes']);
        }
        $type=$schema['type']??'object';
        if($type==='object'&&isset($schema['properties'])) {
            $filtered=[];
            foreach ($schema['properties'] as $key=>$propSchema) {
                $propType=fs($propSchema,'type','string');
                $dont_show=fs($params,$key)===''&&($propType=='string'||$propType=='number')||!fs($params,$key)&&$propType=='boolean';
                if (array_key_exists($key,$params)&&!$dont_show) {
                    $filtered[$key]=aih('filterBySchema',['schema'=>$propSchema,'params'=>is_array($params[$key]) ? $params[$key] : [$params[$key]]]);
                    // unwrap if the property itself is not array/object
                    if ($propType !== 'array' && $propType !== 'object') {
                        $filtered[$key]=txt_d($params[$key]);
                    }
                }
            }
            return $filtered;
        }
        if($type==='array'&&isset($schema['items'])){
            $filtered=[];
            foreach ($params as $index=>$item) {
                if (is_array($item)) {
                    $filtered[$index]=aih('filterBySchema',['schema'=>$schema['items'], 'params'=>$item]);
                } else {
                    $filtered[$index]=$item;
                }
            }
            return $filtered;
        }
        return $params;
    }
    if($act=='temp_vars'){
        $require=[];
        $sessionid=$intent=$vars='';
        extract($arr);
        $vars=[];
        $conversation=aih('conversation',['sessionid'=>$sessionid]);
        $messages=fs($conversation,'messages');
        $intent_message=fs($conversation,'intent_message');
        $can_search=0;
        foreach ($messages as $key=>$mes){
            $mes_prms=fs($mes,'params');
            if(fs($intent_message,'id')==fs($mes,'id')){
                $vars=[];
                $can_search=1;
            }
            if($can_search){
                foreach ($require as $k=>$v){
                    if(fs($mes_prms,$v)){
                        $vars[$v]=fs($mes_prms,$v);
                    }
                }
            }
        }
        return $vars;
    }
    if($act=='img_prompt_setts'){
        $setts=[];
        $code=$prms='';
        extract($arr);

        $prompt='This block will show image that is placed in "img" property. After updaiting "img_prompt" and "img_prompt_media_ids" new image will be generated and uploaded automatically to "img" property, so you don\'t need to upadte it manually';
        
        $this_key='img_prompt';$setts[$this_key]=1;
        $code.=field(['form'=>'textarea','col'=>2,'id'=>$this_key,'hidden'=>1,'type'=>'text','name'=>'Image Prompt','ai_desc'=>'Use natural language to describe image for AI it works on NanoBananaPro so it handles design, text, infographics too','value'=>fs($prms,$this_key) ]);
        $this_key='img_prompt_media_ids';$setts[$this_key]=1;
        $code.=field(['form'=>'imgs','col'=>2,'id'=>$this_key,'hidden'=>1,'type'=>'text','ai_desc'=>'Comma-separated list of media IDs that will be used with prompt as reference images to create a final image based on image input','name'=>'Images for reference','desc'=>'','value'=>fs($prms,$this_key) ]);
        $this_key='img_prompt_orient';$setts[$this_key]=1;
        $select=fs(fs(fs(fs(ai('prices'),'gmnimgl'),'setts'),'aspectRatio'),'select');
        $code.=field(['form'=>'select','select'=>array_combine($select,$select),'col'=>2,'id'=>$this_key,'hidden'=>1,'type'=>'text','name'=>'Orientation','desc'=>'','value'=>fs($prms,$this_key) ]);
        $this_key='img_prompt_resolution';$setts[$this_key]=1;
        $select=fs(fs(fs(fs(ai('prices'),'gmnimgl'),'setts'),'imageSize'),'select');
        $code.=field(['form'=>'select','select'=>[''=>'Default']+array_combine($select,$select),'ai_desc'=>'1K is default resolution always use it, but for follow up messages use 0.5K','col'=>2,'id'=>$this_key,'hidden'=>1,'type'=>'text','name'=>'Resolution','desc'=>'','value'=>fs($prms,$this_key) ]);
    
        return [
            'prompt'=>$prompt,
            'setts'=>$setts,
            'code'=>$code,
        ];
    }
    if($act=='last_message_check'){
        $sessionid=$repeat=$ai_other=$ai_res=$reload='';
        extract($arr);
        
        $message=fs(sql("get",["sql"=>"SELECT * FROM aih_message WHERE sessionid=".$sessionid." ORDER BY id DESC LIMIT 1"]),0);
        $message=($message?:[]);
        $mes_md5=md5(fs($message,'params'));
        $message_prms=json_decode(fs($message,'params'),1);
        $ai_result=fs($message_prms,'ai_result');

        $session=fs(aih('get',['t'=>'session','id'=>$sessionid]),0);
        $session_prms=fs($session,'params');
        $aih_wait=fs($session_prms,'aih_wait');

        $logid=fs($aih_wait,'logid');
        if($aih_wait&&$logid){
            $ai_other=ai('send',['other'=>['logid'=>$logid]]);
        }
        //repeat
        $repeat_last=fs($message_prms,'repeat_last',0);
        $show_retry=0;
        if($aih_wait && fs($aih_wait,'time') && time()-fs($aih_wait,'time') > $max_think_time && !fs($aih_wait,'done')){
            $show_retry=1;
        }

        return ['id'=>fs($message,'id'),'show_retry'=>$show_retry,'message'=>$message,'repeat'=>$repeat,'repeat_diff'=>$max_think_time-(time()-$repeat_last),'md5'=>$mes_md5,'logid'=>$logid,'other'=>$ai_other,'aih_wait'=>$aih_wait,'sessionid'=>$sessionid,'ai_res'=>$ai_res,'reload'=>$reload];
    }
    if($act=='init'){
        $sessionid='';
        extract($arr);
        return aih('run',['sessionid'=>$sessionid]);
    }
    if($act=='ui'){
        $last_session=$jfedit='';
        $code=$trash=$last_message_id=$thinking=$chat_close=$media_ids=$ai_allow=$new_session=$ai_wait=$ai_turn=$new_message=$create_first_message=$hcode=$sessionid=$init=$tcode=$scode='';
        extract($arr);
        $wallet=var_get('wallet',1);
        if($sessionid=='new'){
            $sessionid='';
            $new_session=1;
        }
        $aidie=fs($_REQUEST,'aidie');
        test('info','---------------START---------------');
        test('info',$arr);
        $sessionid=($sessionid&&!is_numeric($sessionid)?sec_d($sessionid):$sessionid);
        $team=fs(team('get',['id'=>$manid]),0);
        $crm_id=fs($team,'crm_id');
        if($jfedit&&!$sessionid){
            $session=fs(aih('get',['t'=>'session','slg'=>'jfedit:'.$jfedit]),0);
            $create_first_message=['jfedit'=>$jfedit];
            if(!$session){
                $sessionid=aih('create',['t'=>'session','params'=>'','manid'=>$manid,'slg'=>'jfedit:'.$jfedit]);
            } else {
                $sessionid=fs($session,'id');
            }
        }
        
        //sessions
        if($last_session||!$sessionid||$new_session){
            $sessions_ar=['t'=>'session','manid'=>$manid];
            $sessions=aih('get',$sessions_ar);
            if(!$sessions||$new_session){
                $sessionid=aih('create',['t'=>'session','params'=>'','manid'=>$manid]);
                $sessions=aih('get',$sessions_ar);
                $create_first_message=1;
            } else {
                $sessionid=fs(fs($sessions,array_key_first($sessions)),'id');
            }
        }
        $session=fs(aih('get',['t'=>'session','id'=>$sessionid]),0);
        $session_prms=fs($session,'params');
        $conversation=aih('conversation',['sessionid'=>$sessionid]);
        $last_aih_wait=fs($conversation,'last_aih_wait');
        if($create_first_message){
            $text=aih('fake_first_message',(is_array($create_first_message)?$create_first_message:[])+['sessionid'=>$sessionid]);
        }
        if($media_ids){
            $media_ids=json_decode($media_ids,1);
            $media_ids=array_keys($media_ids);
            $media_ids=implode(',',$media_ids);
        }
        $convmes=fs($conversation,'messages',[]);
        $last_message=fs($convmes,array_key_last($convmes));
        //new message
        if($new_message){
            $last_state=fs($last_message,'state');
            $last_slug=fs($conversation,'last_slug');

            if($last_slug=='finish'&&fs($last_message,'type',0)==1){//ai
                $last_state='intention_detect';
            }
            $messageid=aih('message',['t'=>'create','params'=>['text'=>$new_message]+($media_ids?['media_ids'=>$media_ids]:[]),'state'=>$last_state,'type'=>0,'sessionid'=>$sessionid]);
            $ai_wait=1;
        }
        //request
        //ai_wait
        //ai_turn
        $retry=fs($arr,'retry');
        if($retry){
            // bump repeat so aih_wait_slug changes, forcing a fresh AI request
            $last_msgs=aih('get',['t'=>'message','sessionid'=>$sessionid,'limit'=>5]);
            foreach($last_msgs as $lm){
                $lm_prms=fs($lm,'params');
                if(fs($lm_prms,'aih_wait') && !fs($lm_prms,'aih_wait_done')){
                    sql('set',['id'=>fs($lm,'id'),'k'=>'repeat','v'=>1,'type'=>'add','t'=>'aih_message','prms'=>1]);
                    sql('set',['id'=>fs($lm,'id'),'k'=>'aih_wait_done','v'=>1,'t'=>'aih_message','prms'=>1]);
                    break;
                }
            }
        }
        if($ai_turn){
            //sleep(3);
            if(0){
                $answer='Hi there what\'s up!!! lsat message:';
            } else {
                //ai
                $run=aih('init',['sessionid'=>$sessionid]);
                $answer=fs($run,'answer');
                if(fs($_REQUEST,'test')){
                    pr($run);
                    die();
                }
            }
        }
        $messages=aih('get',['t'=>'message','sessionid'=>$sessionid]);

        //chats
        if($init||$last_session||$new_session){
            $new=__a('New chat','Новый чат');
            $scode.='<a class="aih_new_session btn btn-light btn-block" href="/crm/?page=aih&sessionid=new">'.$new.'</a>';
            /*
            $scode.='<div class="aih_left_t"><i class="fa fa-fw fa-comments"></i> '.__a('Chat','Чат').'</div>';
            $scode.='<div class="aih_left_t"><i class="fa fa-fw fa-image"></i> '.__a('Images','Картинки').'</div>';*/
            $scode.='<div><br></div>';
            $scode.='<div class="aih_left_t">'.__a('History','История').'</div>';
            $scode.='<div class="aih_sessions">';
            $sessions=aih('get',['t'=>'session','manid'=>$manid,'force'=>$new_session]);
            foreach ($sessions as $key=>$session){
                $tsess_id=fs($session,'id');
                $name=fs($session,'name');
                if($tsess_id==$sessionid&&!$name){
                    $first_message=fs(fs(fs($conversation,'messages'),1),'message');
                    if($first_message){
                        //$conversation
                        $r=ai('send',[
                            'model'=>'groks',
                            'messages'=>[
                                ['r'=>'s','c'=>'You are a copywriter for naming AI chats. Please name this chat topic based on the first user message, user language. Give only topic without any other text'],
                                ['r'=>'u','c'=>$first_message],
                            ]
                        ]);
                        $content=fs($r,'content');
                        if($content){
                            $name=$content;
                            sql('set',['id'=>$sessionid,'k'=>'name','v'=>$content,'t'=>'aih_session']);
                        }
                    }
                }
                
                $is_active=($sessionid==$tsess_id);
                $name=($name?:($is_active?$new:$new.' ID:'.$tsess_id));
                $scode.='<a class="aih_session '.($is_active?'active':'').'" href="/crm/?page=aih&sessionid='.$tsess_id.'" data-id="'.$tsess_id.'">';
                $scode.='<div class="aih_session_name">'.$name.'</div>';
                $links='';
                $links.=mbtn([
                    'html'=>'<i class="fa fa-trash" style=" width:16px;text-align:center;margin-right:5px;font-size:18px;"></i> '.__a('Delete'),
                    'style'=>'dropdown-item',
                    'confirm'=>'ays',
                    'jsafter'=>'aih_upload({"last_session":1});',
                    'php'=>'aih("remove",["t"=>"session","id"=>"'.$tsess_id.'"]);',
                ]);
                $scode.='<div class="aih_session_dropdown">';//dd
                $scode.=html('dropdown',[
                    'id'=>'dropdown_'.$tsess_id,
                    'fa'=>'fa-ellipsis-v',
                    'links'=>$links,
                ]);
                $scode.='</div>';//dd
                $scode.='</a>';
            }
            $scode.='</div>';
        }
        
        //
        //head
        if($init){
            $hcode.='<div class="aih_head">';
            $hcode.='</div>';
        }
        //body
        $code.='<div class="aih_body markdown">';
        if(count($messages)<20||1){
            $code.=aih('octo');
        }
        $messages=array_reverse($messages);
        $oper_count=1;
        $last_taskid=$last_fgid=$finish_link=$prev_slug='';
        foreach ($messages as $key=>$message){
            $mesid=fs($message,'id');
            $last_message_id=$mesid;
            $prms=fs($message,'params');
            $taskid=fs($prms,'taskid');
            if($taskid){
                $last_taskid=$taskid;
            }
            $fgid=fs($prms,'fgid');
            if($fgid){
                $last_fgid=$fgid;
            }
            $slug=fs($message,'slug');
            $text=fs($prms,'text');
            $is_phase=fs($prms,'phase');
            $type=fs($message,'type');
            $media_ids=fs($prms,'media_ids');
            $result=fs($prms,'result');
            $text=txt('markdown2html',$text);
            
            $tool_calls=fs($result,'tool_calls',[]);
            $edit_funnel='';
            $spec='';
            //media_get
            if($slug=='media_get'){
                $type=1;
                $spec.='<div class="row row5" style="max-width:400px;">';
                // Accepted images row
                $spec.='<div class="col-12"><h5>'.t_('example').'</h5><small class="mb-3">'.__a('To look like yourself in the final designs and images, please upload your photos where your face is clearly visible','Чтобы на финальных дизайнах и картинках вы были похожи на себя, пожалуйста загружайте свои фото, где ваше лицо хорошо видно').'</small></div>';
                for($i=2; $i<=4; $i++){
                    $url='https://kozyon.com/instructions/build/pres/accept_'.$i.'.jpeg';
                    $spec.='<div class="col-4 mb-2">';
                    $spec.='<div style="position:relative; width:100%; padding-bottom:100%; border-radius:8px; overflow:hidden;">';
                    $spec.='<img class="m-0" src="'.$url.'" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">';
                    $spec.='<div style="position:absolute; bottom:8px; right:8px; background:#cde266; border-radius:50%; width:30px; height:30px; display:flex; align-items:center; justify-content:center; font-size:18px;">✓</div>';
                    $spec.='</div>';
                    $spec.='</div>';
                }
                for($i=2; $i<=4; $i++){
                    $url='https://kozyon.com/instructions/build/pres/decline_'.$i.'.jpeg';
                    $spec.='<div class="col-4 mb-1">';
                    $spec.='<div style="position:relative; width:100%; padding-bottom:100%; border-radius:8px; overflow:hidden;">';
                    $spec.='<img class="m-0" src="'.$url.'" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">';
                    $spec.='<div style="position:absolute; bottom:8px; right:8px; background:#d0442d; border-radius:50%; width:30px; height:30px; display:flex; align-items:center; justify-content:center; font-size:18px; color:white;">✕</div>';
                    $spec.='</div>';
                    $spec.='</div>';
                }
                $spec.='</div>';
            }
            if($slug=='finish'){
                $finish_link=$last_fgid;
            }
            foreach ($tool_calls as $tool_call) {
                $function=fs($tool_call,'function');
                $name=fs($function,'name');
                if($name=='edit_funnel'){
                    $edit_funnel=$function;
                }
            }
            $me_class=($type?'from_ai':'from_me');
            $text=str_replace('\"','"',$text);
            $code.='<div class="aih_mes_wrap '.$me_class.'" data-md5="'.fs($message,'md5').'" data-id="'.$mesid.'" data-time="'.fs($message,'time').'">';
            
            if(($is_phase||!$text&&!$edit_funnel)&&!$spec){
                
            } else {
                if(!$spec&&(platform()||$trash)){
                    $code.=mbtn(['html'=>'<i class="fa fa-trash"></i>',
                    'class'=>'message_deletter',
                    'php'=>'aih("remove",["t"=>"message","id"=>"'.$mesid.'"]);',
                    'jsafter'=>'$(".aih_mes_wrap[data-id=\''.$mesid.'\']").remove();',
                    ]);
                }
                if($spec){
                    $code.=$spec;
                } else if($edit_funnel){
                    $arguments=fs($edit_funnel,'arguments');
                    foreach ($arguments as $akey=>$value){
                        $value=json_repair($value);
                        $value=($value?:[]);
                        foreach ($value as $k=>$v){
                            if($akey == 'operations'){
                                $entity=fs($v,'entity');
                                $action=fs($v,'action');
                                $name=$entity.' '.$action;
                            }
                            if($akey=='connections'){
                                $name=__a('Nodes connection','Связь нодов');
                            }
                            if($akey=='settings'){
                                $name=__a('Funnel settings','Настройки воронки');
                            }
                            if($oper_count==1){
                                $code.='<h4>'.__a('Completed actions','Выполненные действия').'</h4>';
                            }
                            $code.='<div class="aih_op_item noselect">';
                            $code.='<div class="aih_op_i"><i class="fa fa-ai"></i></div>';
                            $code.='<div class="aih_txt">
                            <div class="aih_op_count">'.__a('Action','Действие').' '.$oper_count.'</div>
                            <div class="aih_op_body">
                            <div class="aih_op_name">'.$name.'</div>
                            <div class="aih_op_prms">'.htmlentities(json_encode($v,JSON_UNESCAPED_UNICODE)).'</div>
                            </div>
                            </div>';
                            $code.='</div>';
                            $oper_count++;
                        }
                    }
                } else {
                    $oper_count=1;
                    $code.='<div class="aih_mes '.$me_class.'">';
                    $code.='<div class="aih_mes_text">'.$text.'</div>';
                    
                    
                    if($media_ids){
                        $medias=media('get',['ids'=>$media_ids]);
                        $code.='<div class="aih_media_list">';
                        foreach($medias as $media){
                            $media_id=fs($media,'id');
                            $media_prms=fs($media,'params');
                            $mime=fs($media_prms,'mime');
                            $mime_type=fs(explode('/',$mime),0);
                            if($mime_type=='image'){
                                $code.='<div class="aih_media_item magpop" data-id="'.$media_id.'" data-magpop="'.fs($media,'url').'" style="background-image:url('.fs($media,'url').');"><div class="magpop_mag"></div><span class="media_id">'.fs($media,'id').'</span></div>';
                            } else {
                                $code.='<div class="aih_media_item" data-id="'.$media_id.'"><div class="absp"><i class="fa fa-file"></i><span>'.mb_substr(fs($media,'name'),0,12).'</span></div><span class="media_id">'.fs($media,'id').'</span></div>';
                            }
                            
                        }
                        $code.='</div>';
                    }
                    $code.='</div>';
                }
                if($prev_slug == 'task_get'){
                    $code.=aih('fg_setts',['fgid'=>$last_fgid,'mesid'=>$mesid]);
                }
                if($finish_link){
                    $fgid=$finish_link;
                    $fg=fs(fg('get',['id'=>$fgid]),0);
                    $code.='<a href="/crm/?page=jf&journey='.$finish_link.'" class="aih_finish_link" target="_blank">
                    <div class="aih_finish_link_i"><i class="fa fa-check-circle"></i></div>
                    <div class="aih_finish_link_txt">
                    <div class="aih_finish_link_t">'.__a('Funnel has been changed','Воронка изменена').'!</div>
                    <div class="aih_finish_link_d">'.pz(sr(__a('To view the changes made by AI to your funnel {name}, click this button','Чтобы посмотреть изменения, которые внес ИИ в вашу воронку {name}, нажмите на эту кнопку'),'{name}','<b>«'.fs($fg,'name').'»</b>')).'
                    </div>
                    </div>
                    </a>';
                    
                    $code.=aih('fg_setts',['fgid'=>$fgid,'mesid'=>$mesid]);
                    $finish_link='';
                }
            }
            $code.='</div>';
            $prev_slug=$slug;    
        }
        $last_error=fs($session_prms,'last_error');
        if($last_error){
            $code.='<div class="admin_note">'.vn().' '.__a('An AI error has been detected, please try repeating the request a little later or resolve the issue through support','Замечена ошибка нейросети, попробуйте повторить запрос чуть позже или решить проблему через поддержку').' '.hand().'<br><br>'.stripslashes($last_error).'</div>';
        }
        if($last_taskid){
            $task=fs(aih('get',['t'=>'ent','id'=>$last_taskid]),0);
            $task_prms=fs($task,'params',[]);
            $taskclose=fs($task_prms,'taskclose');
            if($taskclose&&0){
                $code.='<div class="admin_note">'.vn().' ИИ пока не может редактировать уже созданную воронку, ожидайте несколько дней когда эта функция будет добавлена</div>';
                $chat_close=['reason'=>''];
            }
        }
        if($last_aih_wait&&!fs($last_aih_wait,'done')){
            $session_aih_wait=fs($session_prms,'aih_wait');
            if($session_aih_wait!=$last_aih_wait){
                sql('set',['id'=>$sessionid,'k'=>'aih_wait','v'=>$last_aih_wait,'t'=>'aih_session','prms'=>1]);
            }
            $thinking=1;
        }
        $last_phase_slug=fs($conversation,'last_phase_slug');
        if(substr($last_phase_slug,0,5)=='fill_'){
            if(!fs(fs(fs($message,'params'),'result'),'error')){
                $thinking=1;
            }
        }
        if($ai_wait||$thinking||$ai_turn){
            $thinking=1;
            $chat_close=['reason'=>''];
            $code.='<div class="aih_mes_thinking"><i class="fa fa-lightbulb-o pl-1 pr-1"></i> '.__a('Thinking','Думаю').'<span class="thinking_dotts"></span><span class="separator">•</span><span class="thinking_time"></span></div>';
            $code.='<div class="aih_retry_btn" style="display:none;margin-top:8px;"><button class="btn btn-sm btn-outline-secondary" onclick="aih_retry()">'.__a('Retry request','Повторить запрос').'</button></div>';
        }
        $last_phase_slug=fs($conversation,'last_phase_slug');
        $pay_wall=3;
        
        if(in_array($last_phase_slug,['task_get','need_questions'])){
            $balance_paywall=ai('balance_paywall',['usd'=>$pay_wall,'add'=>'<div class="mt-2">'.sr(__a('One funnel editing request may cost from $0.3 (for minor edits) to {num} (for creating the entire funnel with all images), therefore it is recommended to keep sufficient funds in your wallet so that the funnel creation does not stop halfway','На один запрос редактирования воронки может уходить от $0.3 (на небольшие правки) до {num} (на создание всей воронки со всеми картинками), поэтому рекомендуется держать на кошельке деньги с запасом, чтобы создание воронки не остановилось на полпути'),'{num}','$'.$pay_wall).'</div>']);
            if($balance_paywall){
                $code.=$balance_paywall;
                $chat_close=['reason'=>__a('Not enough balance to continue, please top up your wallet','Недостаточно средств для продолжения, пожалуйста пополните кошелек')];
            }
        }

        
        $code.='</div>';
        //textarea
        if($init){
            $tcode.='<div class="aih_textarea form-group n_fielde">';
            $tcode.='<div class="aih_attach_btn">';//at
            $tcode.='<div class="aih_attach_dropdown">';
            $links='';
            $links.=mbtn([
                'name'=>'<i class="fa fa-cloud-download"></i> '.__a('Media gallery','Медиагалерея'),
                'style'=>'dropdown-item',
                'jsafter'=>'
                aih_textarea.find(".formImgPreview_in.cbf").click();
                ',
            ]);
            $links.=field(['form'=>'imgs','hidden'=>1,'id'=>'mediaupload']);
            $links.=mbtn([
                'name'=>'<i class="fa fa-file-image-o"></i> '.__a('Upload a file','Загрузить файл'),
                'style'=>'dropdown-item',
                'jsafter'=>'
                aih_dropzone.find("input[type=file]").click();
                ',
            ]);
            $tcode.=html('dropdown',[
                'id'=>'dropdown_attach',
                'fa'=>'fa-paperclip',
                'btn'=>'btn-white btn',
                'links'=>$links,
            ]);
            $tcode.='</div>';
            $tcode.='</div>';//at
            $tcode.='<input class="aih_media_ids hidden" name="uploaded_file_id"></input>';
            $tcode.='<textarea class="form-control aih_textarea_textarea" placeholder="'.__a('Enter your message','Введите ваше сообщение').'" rows="1"></textarea>';
            $record=qz('record',['crm_id'=>$crm_id]);
            $tcode.=fs($record,'code');
            $tcode.='<div class="aih_send aih_t_btn">
            <i class="fa fa-arrow-up"></i>
            <i class="fa fa-spinner fa-pulse fa-fw fa_loader"></i>
            </div>';
            $tcode.='</div>';
            $tcode.='<div class="aih_media_list"></div>';
        }
        
        if($init){

        }
        return ['code'=>$code,'balance'=>money(fs($wallet,'b',0),['cur'=>'USD','round'=>2]),'last_message_id'=>$last_message_id,'chat_close'=>$chat_close,'hcode'=>$hcode,'tcode'=>$tcode,'scode'=>$scode,'ai_wait'=>$ai_wait,'thinking'=>$thinking,'sessionid'=>$sessionid];
    }
    if($act=='fg_setts'){
        $fgid=$mesid=$code='';
        extract($arr);
        $code.=html('css','
        body.mfnls .aih_finish_link_btn .field_hider{border:none !important;background:transparent !important;border-radius:30px !important;margin-bottom:10px !important;}
        .aih_finish_link_btn .field_hider_name{background:#fff !important;display:inline-block;border-radius:40px;padding:15px 35px 15px 20px !important;}
        .aih_finish_link_btn .togger_wrap{right:-20px !important;}
        ');
        $fg=fs(fg('get',['id'=>$fgid]),0);
        $fg_prms=fs($fg,'params',[]);
        $aih_profile=fs($fg_prms,'aih_profile');
        $aih_strategy=fs($fg_prms,'aih_strategy');
        $strategy=fs(aih('get',['t'=>'ent','id'=>$aih_strategy]),0);
        $strategy_prms=fs($strategy,'params',[]);
        $t_len=__a('Try not to exceed the length of this free-form text beyond {length} characters, as this may slow down the AI and be excessive for funnel creation','Постарайтесь не превышать длину этого текста, написанного в свободном формате, более {length} символов, так как это может замедлить работу ИИ и будет избыточным для создания воронки');
        $opts=[];
        $profile=fs(aih('get',['t'=>'ent','id'=>$aih_profile]),0);
        $profile_prms=fs($profile,'params',[]);
        if($profile){
            $profile_content=fs($profile_prms,'content');
            $profile_content=!is_array($profile_content)?$profile_content:implode("\n", array_map(fn($key, $value) => "$key: $value",array_keys($profile_content),$profile_content));
            $cont='';
            $t_b=__a('Business information','Информация о бизнесе');
            $name=__a('Profile','Профиль').' - '.$t_b;
            $cont.='<ul style="font-size:12px;margin-bottom:20px;">';
            $cont.='<li>'.__a('The AI takes information from this text when writing texts for websites and messages','Информацию из этого текста ИИ берет, когда пишет тексты для сайтов и сообщений').'</li>';
            $cont.='<li>'.pz(sr($t_len,'{length}','<b>20000</b>')).'</li>';
            $cont.='</ul>';
            $cont.='<form class="ajax_form row">';
            $setts=[];
            $this_key='profile'.$mesid;$setts[$this_key]=1;$this_value=$profile_content;
            $cont.=field(['form'=>'textarea','count'=>1,'name'=>__a('Prompt','Промпт'),'id'=>$this_key,'value'=>$this_value]);
            $php='sql("set",["id"=>'.fs($profile,'id').',"k"=>"content","v"=>"{'.$this_key.'}","t"=>"aih_ent","prms"=>1]);';
            $cont.=mbtn([
                'col'=>1,
                'class'=>'',
                'loader'=>1,
                'name'=>__('Save'),
                'jsafter'=>'',
                'jsbefore'=>'',
                'php'=>$php,
                'reload'=>0
            ]);
            $cont.='</form>';
            $opts['profile']=[
                'n'=>$name,
                'cont'=>$cont,
            ];
        }
        $aih_strategy=fs($fg_prms,'aih_strategy');
        $strategy=fs(aih('get',['t'=>'ent','id'=>$aih_strategy]),0);
        if($strategy){
            $cont='';
            $strategy_prms=fs($strategy,'params',[]);
            $name=__a('Visual Style Settings','Настройки визуального стиля');

            $cont.='<ul style="font-size:12px;margin-bottom:20px;">';
            $cont.='<li>'.__a('The AI takes information from this text when creating images for your funnel','Информацию из этого текста ИИ берет, когда создает картинки для вашей воронки').'</li>';
            $cont.='<li>'.pz(sr($t_len,'{length}','<b>2000</b>')).'</li>';
            $cont.='</ul>';
            $cont.='<form class="ajax_form row">';
            $setts=[];
            $this_key='visual_pref'.$mesid;$setts[$this_key]=1;$this_value=fs($strategy_prms,'visual_pref');
            $cont.=field(['form'=>'textarea','count'=>1,'name'=>__a('Prompt','Промпт'),'id'=>$this_key,'value'=>$this_value]);
            $php='sql("set",["id"=>'.fs($strategy,'id').',"k"=>"visual_pref","v"=>"{'.$this_key.'}","t"=>"aih_ent","prms"=>1]);';
            $cont.=mbtn([
                'col'=>1,
                'class'=>'',
                'loader'=>1,
                'name'=>__('Save'),
                'jsafter'=>'',
                'jsbefore'=>'',
                'php'=>$php,
                'reload'=>0
            ]);
            $cont.='</form>';
            $opts['strategy']=[
                'n'=>$name,
                'cont'=>$cont,
            ];
        }
        $name=__a('Images for reference','Картинки для референса');
        $cont='';
        $cont.='<ul style="font-size:12px;margin-bottom:20px;">';
        $cont.='<li>'.__a('The AI uses these images as references when creating new images for your funnel','Эти картинки ИИ берет в качестве референса, когда создает новые картинки для вашей воронки').'</li>';
        $cont.='<li>'.__a('If you want to change the reference images, tell the AI agent in this chat "I want to change the reference images in my funnel"','Если вы хотите поменять картинки для референса, скажите ИИ агенту в этом чате "Я хочу изменить картинки для референса в моей воронке"').'</li>';
        $cont.='</ul>';
        $media=fs($strategy_prms,'media');
        $after='';
        if($media){
            $cont.=html('css','
            .aih_media_icons{}
            .aih_media_icon{display:flex;margin-bottom:20px;}
            .aih_media_item{}
            .aih_media_txt{font-size:12px;padding-left:15px;}
            .aih_media_txt_desc{}
            .aih_media_txt_meaning{}
            ');
            $cont.='<div class="aih_media_icons">';
            foreach($media as $med){
                $mid=fs($med,'mediaid');
                $media=fs(media('get',['id'=>$mid]),0);
                $cont.='<div class="aih_media_icon">';
                $cont.='<div class="aih_media_item magpop mt-0" data-id="'.$mid.'" data-magpop="'.fs($media,'url').'" style="background-image:url('.fs($media,'url').');min-width:100px;height:100px;border:2px solid #fff;"><div class="magpop_mag"></div></div>';
                $cont.='<div class="aih_media_txt">';
                $cont.='<div class="aih_media_txt_desc"><b>'.__a('Description','Описание').'</b>: '.fs($med,'description').'</div>';
                $cont.='<div class="aih_media_txt_meaning"><b>'.__a('Meaning','Значение').'</b>: '.fs($med,'meaning').'</div>';
                $cont.='</div>';
                $cont.='</div>';
                $after.='<div class="aih_media_item magpop mt-0" data-id="'.$mid.'" data-magpop="'.fs($media,'url').'" style="background-image:url('.fs($media,'url').');width:50px;height:50px;border:2px solid #fff;"><div class="magpop_mag"></div></div>';
            }
            $cont.='</div>';
        } else {
            $cont.='<div class="admin_note">'.__a('You have not added a single image, which we do not recommend because the images that the AI will create will not rely on your visual style','Вы не добавили ни одной картинки, что мы делать не рекомендуем, потому что картинки, которые будет создавать ИИ, не будут опираться на ваш визуальный ряд').'</div>';
        }
        $opts['media']=[
            'n'=>$name,
            'cont'=>$cont,
            'after'=>'<div class="aih_media_list" style="gap:2px;">'.$after.'</div>',
        ];

        $code.='<div class="aih_finish_link_btn">';
        $code.='<small class="text-muted aih_finish_link_btn_title">'.__a('These settings are used when editing the funnel','Эти настройки используются при редактировании воронки').'</small>';

        $code.='<div class="hider_group">';
        foreach ($opts as $key => $value) {
            $code.=html('hider',['n'=>fs($value,'n'),'start'=>1]);
            $code.='<h2 class="mb-3">'.fs($value,'n').'</h2>';
            $code.=fs($value,'cont');
            $code.=html('hider',['start'=>0]);
            $code.=fs($value,'after');
        }
        $code.='</div>';


        $code.='</div>';
        return $code;
    }
    if($act=='html_ui_init'){
        global $current_manager_info;
        $manid=fs($current_manager_info,'id');
        $crm_id=fs($current_manager_info,'crm_id');
        extract($arr);
        $wallet=var_get('wallet',1);
        $code='';
        $code.=qz('record_js',['crm_id'=>$crm_id]);
        $code.=aih('css_js');
        //<div class="close"></div>
        //dropzone


        $upload_folder=media('trash_meida_id');
        $dropzone_html=media('dropzone', [
            'editor'=>'',
            'close'=>1,
            'allow'=>'jpg,png,jpeg,gif,webp,pdf,txt,doc,docx',
            'folder'=> $upload_folder,
            'max'=>50000000, // Optional: 50MB max size (overrides default)
            'jsafter'=>'body_element.removeClass("dragging-files");' // Optional: JS to run after (e.g., reload page)
        ]);
        $code.='<div class="aih_dropzone">'.$dropzone_html.'</div>';
        $code.='<div class="aih_grand_wrap">
        <div class="aih_grand_left">
            <div class="scrollbar-macosx">
            <div class="aih_sessions_in"></div>
            </div>
            <div class="aih_wallet cbf" '.cbf('ai:balance',['manid'=>$manid,'htmlbefore'=>base64_encode('<div class="p-3"></div>')],['width'=>'500px','noblack_input'=>1,'height'=>'300px','radius'=>'20px','color'=>'#fff']).'><i class="fa fa-wallet"></i>&nbsp;'.__a('Wallet','Кошелек').':&nbsp;<b class="aim">'.money(fs($wallet,'b',0),['cur'=>'USD','round'=>2]).'</b></div>
        </div>
        <div class="aih_grand_right">
            <div class="aih_head_in"></div>
            <div class="aih_body_in"></div>
            <div class="aih_textarea_in"></div>
            '.(platform()&&fs($_REQUEST,'dev')?'<div class="test_btns"><div class="test_btn no_ai"><i class="fa fa-ban"></i></div><div class="test_btn ai_start"><i class="fa fa-ai"></i></div></div>':'').'
        </div>';

        $code.='<form class="ajax_form hidden last_message_checker row">';
        $code.=field(['form'=>'field','name'=>'','id'=>'sessionid','value'=>'']);
        $code.=mbtn([
            'col'=>1,
            'class'=>'',
            'loader'=>1,
            'name'=>__('Save'),
            'jsafter'=>'last_message_check(arg_request);',
            'jsbefore'=>'',
            'php'=>'
            $sessionid=sql("safe","{sessionid}")?:1;
            echo "&&$#((#&&$".json_encode(aih("last_message_check",["sessionid"=>$sessionid]),JSON_UNESCAPED_UNICODE);
            ',
            'reload'=>0
        ]);
        $code.='</form>';


        $code.='<form class="ajax_form hidden aih_loader row">';
        $setts=[];
        $this_key='aih_info';$setts[$this_key]=1;$this_value=1;
        $code.=field(['form'=>'textarea','name'=>'','id'=>$this_key]);
        $php='
        $aih_info=txt_d("{aih_info}");
        $aih_info=json_decode($aih_info,1);
        $aih_info=is_array($aih_info)?$aih_info:[];
        $aih_info["manid"]="'.$manid.'";
        $aih_info["trash"]=txt_d("'.txt_e(fs($_REQUEST,'dev')).'");
        '.(fs($_REQUEST,'jfedit')?'$aih_info["jfedit"]=txt_d("'.txt_e(fs($_REQUEST,'jfedit')).';t:'.time().'");':'').'
        $aih_ui=aih("ui",$aih_info);
        echo "&&$#((#&&$".json_encode($aih_ui,JSON_UNESCAPED_UNICODE);
        ';
        $code.=mbtn([
            'col'=>1,
            'class'=>'',
            'loader'=>1,
            'name'=>__('Save'),
            'jsafter'=>'
                aih_load(arg_request);
            ',
            'jsbefore'=>'',
            'php'=>$php,
            'reload'=>0
        ]);
        $code.='</form>';
        $code.='</div>';
        return $code;
    }
    if($act=='css_js'){
        ob_start();?>
<style>
:root{
    --aic-t-btn-size:40px;
    --aih-left-width:250px;
}
p,li{line-height:1.4;}
.aih_wallet{border-top:1px solid #eaeaea;height:80px;display:flex;justify-content:center;align-items:center;flex-direction:row;cursor:pointer;}
.admin_container.aih{padding:0 !important;max-width:none;}
.aih_head_in{}
.aih_body_in{max-width:750px;margin:auto;}
.aih_grand_wrap{min-height:100vh;position:relative;}
.aih_grand_left{width:var(--aih-left-width);height:100vh;border-right:1px solid #11111117;position:fixed;padding-bottom:80px;}
.aih_grand_right{padding-left:var(--aih-left-width);}

.test_btns{position:absolute;bottom:0;right:30px;display:flex;z-index:9;opacity:0.2;}
.test_btns:hover{opacity:1;}
.test_btn{width:20px;height:20px;font-size:12px;display:flex;align-items:center;justify-content:center;border-radius:5px;}
.test_btn.active{background:#000000;color:#fff;}

/*dropzone*/
.aih_dropzone{padding:20px;position:fixed;width:calc(100% - var(--admin-menu-width));height:100%;top:0;left:var(--admin-menu-width);z-index:99;background:#00000026;display:none;}
body.dragging-files .aih_dropzone{display:block;}
.aih_dropzone .dropzone_wrap{position:absolute;width:100%;height:100%;left:0;top:0;}
.aih_dropzone .dropzone_zone{position:absolute;top:0;left:0;width:100%;height:100%;height:100%;background:transparent;border:0;}
.aih_dropzone .dropzone_mes{background:#fff;padding:60px 40px 40px !important;max-width:380px;margin:0 auto;border-radius:20px;}
.aih_media_list{display:flex;flex-wrap:wrap;gap:10px;}
.aih_media_item{background-color:#bfbfbf;position:relative;width:60px;height:60px;margin:10px 0 0;background-size:cover;background-position:center;background-repeat:no-repeat;border-radius:5px;}
.aih_media_item .media_id{position:absolute;z-index:9;right:0;bottom:0;background:#111;color:#fff;font-size:8px;padding:0 3px;border-radius:5px 0;}
.aih_media_item .absp i{font-size:24px;color:#11111175;}
.aih_media_item .absp span{font-size:10px;color:#11111175;}
.aih_media_item .absp{display:flex;align-items:center;justify-content:center;flex-direction:column;}
.aih_media_item_remove{position:absolute;width:30px;height:30px;background:#111;right:-8px;top:-8px;border-radius:100px;color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;cursor:pointer;}

/*sessions*/
.aih_sessions_in{padding:15px;padding-bottom:200px;}
.aih_left_t{font-size:14px;font-weight:600;margin-bottom:6px;}
.aih_sessions{}
.aih_session{padding:10px;border-radius:10px;cursor:pointer;position:relative;display:block;text-decoration:none !important;color:#111 !important;}
.aih_session:after{content:'';position:absolute;width:20px;height:100%;background:linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgb(255 255 255) 100%);right:0;top:0;border-radius: 0 10px 10px 0;}
.aih_session.active:after,.aih_session:hover:after{background:linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgb(243 243 243) 100%);}
.aih_session:hover,.aih_session.active{background:#f3f3f3;}
.aih_session_dropdown{position:absolute;top:5px;right:5px;height:calc(100% - 10px);}
.aih_session_dropdown>*{opacity:0;}
.aih_session_dropdown>*.show{opacity:1;}
.aih_session_dropdown>*,.aih_session_dropdown>*>*:not(.dropdown-menu){height:100%;}
.aih_session_dropdown>*>* [type="button"]{padding:0 3px;height:100%;background:transparent;border:0;color:#111;background:#fff;z-index:2;position:relative;}
.aih_session:hover .aih_session_dropdown>*{opacity:1;}
.aih_session_name{white-space:nowrap;overflow:hidden;width:calc(100% + 10px);}

.aih_body{padding:30px;min-height:100vh;display:flex;flex-direction:column;justify-content:flex-end;}
.aih_textarea{padding:10px;border:1px solid #e5e5e5;border-radius:30px;display:flex;align-items:center;background:#f9f9f9;align-items:flex-end;margin:0 !important;}

.aih_textarea textarea{max-height:calc(400px - 20px);min-height:var(--aic-t-btn-size);font-size:16px !important;border:none;resize:none;padding:10px;background:transparent !important;width:calc(100% - var(--aic-t-btn-size) - var(--aic-t-btn-size) - var(--aic-t-btn-size));flex: 1 0 auto;}

.aih_textarea.recording>*:not(.aic_write_area){display:none;}
.aih_t_btn,.aic_t_btn,.aih_attach_btn{width:var(--aic-t-btn-size);height:var(--aic-t-btn-size);display:flex;align-items:center;justify-content:center;cursor:pointer;}
.aic_write_area{top:0;}
body .aic_write_area,.aic_t_btn{flex: 0 0 auto;width:var(--aic-t-btn-size);}
.aih_send{background:#111;color:#fff;border-radius:100px;}
.aih_textarea:not(.has-value) .aih_send{opacity:1;pointer-events:none;background:#e4e4e4;color:#9b9b9b;}
.aih_textarea_in{position:fixed;bottom:0;left:calc(var(--aih-left-width) + var(--admin-menu-width));width:calc(100% - var(--aih-left-width) - var(--admin-menu-width));padding:30px;background: linear-gradient(0deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);max-width:760px;margin:0 auto;right:0;z-index:9;}
.aih_textarea_in.closed{pointer-events:none;}

.aic_t_mes.aic_microphone{left:-5px;}
.aic_t_mes.aic_microphone:before{display:none;}
.aic_write_area:not(.recording) .aic_textarea_btns>*:not(.aic_microphone){display:none;}
.aih_send{max-width:calc(100% - 60px);}

.aih_retry_btn{text-align:left;}
.aih_retry_btn button{border-radius:20px;font-size:12px;}

.aih_attach_btn{}
.aih_attach_btn .btn{border-radius:100px;}
.aih_attach_btn .btn:not(:hover){background:transparent;}
.aih_attach_dropdown{}
.aih_attach_dropdown .dropdown-menu a{text-align:center;margin-right:5px;display:block;}
.aih_attach_btn button i{transform: scale(1.1) rotate(43deg);}

.aic_write_area.recording{width:100% !important;}

/*messages*/
.aih_mes{max-width:90%;}
.aih_mes.from_me{background:#f2f2f2;padding:10px 15px;border-radius:30px 30px 10px 30px;}
.aih_mes_wrap{display:flex;flex-direction:column;align-items:flex-end;position:relative;}
.aih_mes_wrap.from_ai{align-items:flex-start;}
.aih_mes_wrap .aih_mes{margin-bottom:10px;}
.message_deletter{position:absolute;font-size:10px;right:0;top:0;background:#ffffff;padding:5px;border-radius:100px;opacity:0.2;border:1px solid #2222223d;display:none;}
.aih_mes_wrap:hover .message_deletter{display:block;}
.fa_loader{font-size:24px;}
.aih_grand_wrap:not(.loading) .aih_send .fa_loader{display:none;}
.aih_grand_wrap.loading .aih_send .fa:not(.fa_loader){display:none;}
.aih_grand_wrap.hard_loading .aih_grand_right{opacity:0.3;pointer-events:none;}
.aih_grand_wrap.thinking {}


.aih_mes_thinking{display:inline-block;padding:5px 10px;color:#11111175;width:auto;align-self:flex-start;background:#f2f2f2;border-radius:20px;}
.thinking_time{font-family:monospace;}
.aih_mes_thinking .separator{font-size:10px;top:-1px;position:relative;color:transparent;padding:0 15px 0 0;}
.thinking_dotts::after{content:'';animation:dots 1s infinite;position:absolute;}

.aih_op_item{cursor:default;display:flex;margin-bottom:10px;width:100%;background:#f2f2f2;border-radius:20px;}
.aih_op_i{font-size:30px;padding:6px 15px;color:#b7b7b7;font-size:20px;}
.aih_txt{font-size:12px;display:flex;flex-direction:column;justify-content:center;min-width:0;padding:5px 0;}
.aih_op_count{font-weight: 600;}
.aih_op_name{}
.aih_op_prms{word-wrap:break-word;display:none;}
.aih_op_item.open .aih_op_prms{display:block;}

.aih_finish_link{display:block;padding:10px;width:100%;border-radius:20px;margin-bottom:25px;color:#111 !important;display:flex;align-items:center;background:#027bff;color:#fff !important;}
.aih_finish_link_t{font-weight:600;font-size:20px;}
.aih_finish_link_i{font-size:30px;padding:10px;margin-right:10px;}
.aih_finish_link_d{font-size:12px;max-width:300px;line-height:1;}
.aih_finish_link_btn{background:#f2f2f2;padding:15px 15px 5px;border-radius:20px;margin-bottom:40px;width:100%;}
.aih_finish_link_btn_title{margin:0 0 10px !important;}


@keyframes dots { 0% { content:'';} 45% { content:'.';} 60% { content:'..';} 75%, 100% { content:'...';}}
</style>
<script>(function($) {"use strict";$(document).ready(function(){setTimeout(function(){
window.aih_grand_wrap=body_element.find(".aih_grand_wrap");
window.aih_dropzone=$(".aih_dropzone");
window.aih_textarea=aih_grand_wrap.find(".aih_textarea");
window.aih_textarea_in=aih_grand_wrap.find(".aih_textarea_in");
window.aih_textarea_textarea='';
window.aih_body_in=aih_grand_wrap.find(".aih_body_in");
window.aih_body=aih_grand_wrap.find(".aih_body");
window.aih_loader=aih_grand_wrap.find(".aih_loader");
window.aih_grand_left=aih_grand_wrap.children(".aih_grand_left");
window.last_message_checker=aih_grand_wrap.find(".last_message_checker");
window.thinking_timer=null;
window.aih_init='';
window.canv_imageCache=new Map();
url_prm('remove','jfedit');


$(document).on('click','.aih_op_item',function(){
    var $this=$(this);
    $this.toggleClass('open');
});


//dropzone
$(document).on('success','.dropzone_input', function(e, opt) {
    var result=opt.result; // JSON from upload.php, e.g. {mediaid: '123', ...}
    if(result.mediaid){
        var mediaIdsField=aih_textarea.find('.aih_media_ids');
        var existingValue=mediaIdsField.val();
        var mediaObj={};
        if(existingValue && existingValue.trim()!==''){
            try {
                mediaObj=JSON.parse(existingValue);
                if(typeof mediaObj !== 'object' || mediaObj === null || Array.isArray(mediaObj)){
                    mediaObj={};
                }
            } catch(e) {
                mediaObj={};
            }
        }

        if(Object.keys(mediaObj).length >= 10 && !mediaObj.hasOwnProperty(result.mediaid)){
            showNotification('Maximum 10 files allowed');
            return;
        }

        if(!mediaObj.hasOwnProperty(result.mediaid)){
            mediaObj[result.mediaid]=result;
        }
        update_aih_media_list(Object.values(mediaObj));
        mediaIdsField.val(JSON.stringify(mediaObj));
    } else if (result.error) {
        mod_run('Upload error: '+result.error);
    }
});
aih_dropzone.find('.dropzone_wrap').on('upload:before',function(){
    body_element.addClass("dragging-files");
});
$(document).on('set:img','#mediaupload',function(e,opt){
    var medias=fs(opt,"medias");
    update_aih_media_list(medias);
});

var containsFiles=function(event) {
    if (event.dataTransfer && event.dataTransfer.types) {
        for (var i=0; i < event.dataTransfer.types.length; i++) {
            if (event.dataTransfer.types[i] === "Files") {
                return true;
            }
        }
    }
    return false;
}
var update_aih_media_list=function(media_array){
    var mediaIdsField=aih_textarea.find('.aih_media_ids');
    var existingObj={};
    var currentValue=mediaIdsField.val();
    if (currentValue) {
        try {
            existingObj=JSON.parse(currentValue);
            if (typeof existingObj !== 'object' || existingObj === null || Array.isArray(existingObj)) {
                existingObj={};
            }
        } catch (e) {
            existingObj={};
        }
    }
    $.each(media_array, function(key, media) {
        var media_id=fs(media, 'mediaid');
        existingObj[media_id]=media;
    });

    var allKeys=Object.keys(existingObj);
    var max_files=<?php echo $max_files; ?>;
    if(allKeys.length > max_files){
        var removed=allKeys.slice(max_files);
        $.each(removed, function(i, key){
            delete existingObj[key];
        });
        mediaIdsField.val(JSON.stringify(existingObj));
        showNotification('Maximum '+max_files+' files allowed');
    } else {
        mediaIdsField.val(JSON.stringify(existingObj));
    }
    var code='';
    $.each(Object.values(existingObj), function(key, media) {
        var media_id=fs(media, 'mediaid');
        var mime_type=fs(media, 'mime_type');
        var url=fs(media, 'url');
        var remove_code='<div class="aih_media_item_remove"><i class="fa fa-times"></i></div>';
        if (mime_type == 'image') {
            code += '<div class="aih_media_item" data-json="'+txt_e(JSON.stringify(media))+'" data-id="' + media_id + '" style="background-image:url(' + url + ');">' + remove_code + '</div>';
        } else {
            var escapedName=$('<div>').text(fs(media, 'name')).html(); // HTML-encode the filename
            escapedName=escapedName.substring(0, 12);
            code += '<div class="aih_media_item" data-json="'+txt_e(JSON.stringify(media))+'" data-id="' + media_id + '"><div class="absp"><i class="fa fa-file"></i><span>' + escapedName + '</span></div>' + remove_code + '</div>';
        }
    });
    aih_grand_wrap.find('.aih_textarea_in .aih_media_list').html(code);
    function_check_has_value();
};
$(document).on('click','.aih_media_item_remove',function(){
    var media_item=$(this).closest('.aih_media_item');
    var mediaid=media_item.attr('data-id');
    var mediaIdsField=aih_textarea.find('.aih_media_ids');
    
    // Get current media obj from the field
    var mediaObj={};
    var currentValue=mediaIdsField.val();
    if(currentValue){
        try {
            mediaObj=JSON.parse(currentValue);
            if(typeof mediaObj !== 'object' || mediaObj === null || Array.isArray(mediaObj)){
                mediaObj={};
            }
        } catch(e) {
            mediaObj={};
        }
    }
    delete mediaObj[mediaid];
    mediaIdsField.val(JSON.stringify(mediaObj));
    update_aih_media_list(Object.values(mediaObj));
});

let dragCounter=0;
let dragTimeout;
$(document).on('dragenter', function(e) {
    e.preventDefault();
    e.stopPropagation();
    if (containsFiles(e.originalEvent)) {
        dragCounter++;
        body_element.addClass('dragging-files');
        if (dragTimeout) {
            clearTimeout(dragTimeout);
        }
        console.log('File drag entered'); // For debugging
    }
});
$(document).on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    // Keep the class if files are being dragged over
    if (containsFiles(e.originalEvent)) {
        // No need to increment counter here, just prevent default to allow drop
        console.log('File drag over'); // For debugging
    }
});
$(document).on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (containsFiles(e.originalEvent)) {
        dragCounter--;
        if (dragCounter === 0) {
            // Use a short timeout to handle quick leave/enter events
            dragTimeout=setTimeout(function() {
                body_element.removeClass('dragging-files');
                console.log('File drag left'); // For debugging
            }, 100);
        }
    }
});
$(document).on('click','.dropzone_close',function(e){
    e.preventDefault();
    e.stopPropagation();
    aih_dropzone.hide();
});
$(document).on('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    dragCounter=0;
});






//test btns

body_element.on("click",".test_btn",function(){
    if($(this).hasClass("ai_start")){
        aih_upload({'ai_turn':1});
    } else {
        $(this).toggleClass("active");
    }
});

body_element.on("click",".aih_textarea",function(e) {
    if(e.target===this){
        $(this).find("textarea").focus();
    }
});

window.aih_recalculate_aih_body_in=function(){
    var height=aih_textarea_in.outerHeight();
    aih_body.css('padding-bottom',height+'px');
}


//init
$(window).scrollTop($(document).height());
if('scrollRestoration' in history) {
    history.scrollRestoration='manual';
}



window.canv_ImagesInParent=function(parent){
    $('img',parent).each(function() {
        const src=this.src;
        if(src && !canv_imageCache.has(src)) {
            const preloadImg=new Image();
            preloadImg.src=src;
            canv_imageCache.set(src, preloadImg); // Store reference to ensure cache persistence
        }
    });
    $('*',parent).filter(function() {
        return $(this).css('background-image') !== 'none';
    }).each(function() {
        let bgImage=$(this).css('background-image');
        // Extract URL from background-image (handles url("...") or url('...'))
        const urlMatch=bgImage.match(/url\(["']?([^"']*)["']?\)/);
        const src=urlMatch ? urlMatch[1] : null;
        if (src && !canv_imageCache.has(src)) {
            const preloadImg=new Image();
            preloadImg.src=src;
            canv_imageCache.set(src, preloadImg); // Store reference to ensure cache persistence
        }
    });
};



//▒█▀▀▀█ ▒█▀▀▀ ▒█▀▀▀█ ▒█▀▀▀█ ▀█▀ ▒█▀▀▀█ ▒█▄░▒█ 
//░▀▀▀▄▄ ▒█▀▀▀ ░▀▀▀▄▄ ░▀▀▀▄▄ ▒█░ ▒█░░▒█ ▒█▒█▒█ 
//▒█▄▄▄█ ▒█▄▄▄ ▒█▄▄▄█ ▒█▄▄▄█ ▄█▄ ▒█▄▄▄█ ▒█░░▀█
//new session
$(document).on("click",'.aih_new_session',function(e){
    e.preventDefault();
    aih_upload({new_session:1});
});
$(document).on("click",'.aih_session',function(e){
    e.preventDefault();
    var target=$(e.target);
    if(target.closest('.aih_session_dropdown').length){
        return;
    }
    var sessionid=$(this).attr('data-id');
    url_prm('set','sessionid',sessionid);
    aih_upload({sessionid:sessionid,hard_loading:1});
});



var function_check_has_value=function(){
    var val=aih_textarea.find('textarea').val().trim();
    var files_childs=aih_grand_wrap.find('.aih_textarea_in .aih_media_list>*');
    if(val||files_childs.length){
        aih_textarea.addClass("has-value");
    } else {
        aih_textarea.removeClass("has-value");
    }
    aih_recalculate_aih_body_in();
}

//textarea
$(document).on('input','.aih_textarea textarea',function(){
    function_check_has_value();
});

//recording
$(document).on('record_start',function(e,aic_write_area){
    aih_textarea.addClass("recording");
});
$(document).on('record_cancel',function(e,aic_write_area){
    aih_textarea.removeClass("recording");
});
$(document).on('record_finished',function(e,aic_write_area){
    aih_textarea.removeClass("recording");
});


//enter key to send
$(document).on('keydown','.aih_textarea_textarea',function(e){
    if(e.key==='Enter'&&!e.shiftKey){
        e.preventDefault();
        body_element.find('.aih_send').click();
    }
});

//send message
body_element.on("click",".aih_send",function(){
    var message=aih_textarea_textarea.val().trim();
    var files_childs=aih_grand_wrap.find('.aih_textarea_in .aih_media_list>*');
    if(message||aih_grand_wrap){
        message=(message?message:'->');
        aih_upload({new_message:message,});
        aih_textarea_textarea.val('');
        aih_textarea_textarea.trigger('input');
    }
});

window.aih_scroll_down=function(opt={}){
    var behavior=fs(opt,'behavior','smooth');
    var run_last_time=fs(opt,'run_last_time');
    var targetScroll=fs(opt,'targetScroll');
    var object=fs(opt,'object');
    $('html').stop(true);
    // figure out where to scroll to
    if(!targetScroll){
        var targetScroll=$(document).height();
        if(object.length){
            targetScroll=object.offset().top - aic_menu_head - 20;
        }
    }
    // remember where we started
    let lastScrollTop=window.pageYOffset;
    // kick off the smooth scroll
    window.scrollTo({ top: targetScroll, behavior: behavior });
    // inner detector: every 100ms, check if scrollTop has changed
    const detectScrollEnd=()=>{
        const currentScrollTop=window.pageYOffset;
        const distance=Math.abs(currentScrollTop - lastScrollTop);
        if (distance === 0) {
            console.log('Scrolling ended',opt);
            opt['run_last_time']=1;
            opt['targetScroll']=targetScroll;
            aih_scroll_down(opt);
            clearInterval(checkInterval);
        } else {
            lastScrollTop=currentScrollTop;
        }
    };
    // start polling
    if(!run_last_time){
        var checkInterval=setInterval(detectScrollEnd,5);
    }

};


window.aih_retry=function(){
    var sessionid=aih_grand_wrap.attr("data-sessionid");
    // Increment repeat counter on last user message server-side, then re-run
    aih_grand_wrap.find('.aih_retry_btn').hide();
    aih_upload({'ai_turn':1,'retry':1});
};
var thinking_timer_elem='';
window.aih_thinking=function(opt){
    var action=fs(opt,'action');
    if(action=='start'){
        clearInterval(thinking_timer);
        var startTime=Date.now();
        thinking_timer=setInterval(function() {
            var elapsed=Math.floor((Date.now() - startTime) / 1000);
            thinking_timer_elem.text(elapsed+'s');
        }, 1000);
        aih_grand_wrap.addClass('thinking');
    }
    if(action=='stop'){
        clearInterval(thinking_timer);
        aih_grand_wrap.removeClass('thinking');
    }
}
//upload
window.aih_upload=function(opt){
    var hard_loading=fs(opt,'hard_loading');
    if(hard_loading){
        aih_grand_wrap.addClass("hard_loading");
    }
    if(aih_textarea_textarea){
        aih_textarea_textarea.attr('readonly',true);
    }
    aih_grand_wrap.addClass("loading");
    if(!fs(opt,'sessionid')){
        var sessionid=aih_grand_wrap.attr("data-sessionid");
        opt.sessionid=sessionid;
    }
    var aih_media_ids=aih_textarea.find('.aih_media_ids').val();
    if(aih_media_ids){
        opt.media_ids=aih_media_ids;
        aih_textarea.find('.aih_media_ids').val('');
        update_aih_media_list();
    }
    opt=JSON.stringify(opt);
    aih_loader.find('textarea').val(opt);
    aih_loader.find('[data-eval]').click();
}
//load
//request
window.aih_load=function(arg_request){
    aih_grand_wrap.removeClass("loading");
    aih_grand_wrap.removeClass("hard_loading");
    
    var res=arg_request.split("&&$#((#&&$");
    if(fs(res,0)){
        mod_run(fs(res,0));
    }
    
    var json=JSON.parse(fs(res,1));
    console.log('---==---=---=-');
    console.log(json);

    
    var code=fs(json,"code");
    var hcode=fs(json,"hcode");
    var tcode=fs(json,"tcode");
    var scode=fs(json,"scode");
    var balance=fs(json,"balance");
    var chat_close=fs(json,"chat_close");
    var last_message_id=fs(json,"last_message_id");
    if(scode){$(".aih_sessions_in").html(scode);}
    if(hcode){$(".aih_head_in").html(hcode);}
    if(code){$(".aih_body_in").html(code);}
    if(tcode){$(".aih_textarea_in").html(tcode);}
    aih_grand_left.find(".aim").html(balance);
    
    var ai_wait=fs(json,"ai_wait");
    var thinking=fs(json,"thinking");
    var block_ai=aih_grand_wrap.find('.test_btn.no_ai.active').length;
    if(block_ai){
        ai_wait=0;
    }

    var sessionid=fs(json,"sessionid");
    if(thinking){
        aih_thinking({action:'start'});
    } else {
        aih_thinking({action:'stop'});
    }
    if(sessionid){
        url_prm('set','sessionid',sessionid);
    }
    aih_grand_wrap.attr("data-last_message_id",last_message_id);
    aih_grand_wrap.attr("data-sessionid",sessionid);
    aih_grand_left.find(".aih_session").removeClass("active");
    aih_grand_left.find(".aih_session[data-id='"+sessionid+"']").addClass("active");
    aih_body=aih_grand_wrap.find(".aih_body");
    aih_grand_left=aih_grand_wrap.children(".aih_grand_left");
    aih_textarea=aih_grand_wrap.find(".aih_textarea");
    aih_textarea_textarea=aih_textarea.find("textarea");
    aih_textarea_textarea.attr('readonly',false);
    thinking_timer_elem=aih_grand_wrap.find('.aih_mes_thinking').find('.thinking_time');
    if(chat_close){
        aih_textarea_in.addClass('closed');
    } else {
        aih_textarea_in.removeClass('closed');
    }

    canv_ImagesInParent(aih_grand_wrap);
    new_site_element_on_screen(aih_grand_wrap);
    aih_recalculate_aih_body_in();
    
    if(fonts_have_loaded){
        aih_scroll_down();
    }
    
    
    if(ai_wait){
        setTimeout(function(){
            aih_upload({'ai_turn':1});
        },1);
    }
}
//initer
var sessionid=url_prm('get','sessionid');
var ar={'init':1,'sessionid':sessionid};
aih_upload(ar);
var fonts_have_loaded=0;
if (document.fonts) {
    //wait for font loaded
    document.fonts.forEach(function(font){
        font.loaded.then(function(){
            if(font.family=='in'&&!fonts_have_loaded){
                fonts_have_loaded=1;
                aih_scroll_down();
            }
        });
    });
} else {
    fonts_have_loaded=1;
}




        //▒█▄░▒█ ▒█▀▀▀ ▒█░░▒█ 　 ▒█▀▄▀█ ▒█▀▀▀ ▒█▀▀▀█ ▒█▀▀▀█ ░█▀▀█ ▒█▀▀█ ▒█▀▀▀ 
        //▒█▒█▒█ ▒█▀▀▀ ▒█▒█▒█ 　 ▒█▒█▒█ ▒█▀▀▀ ░▀▀▀▄▄ ░▀▀▀▄▄ ▒█▄▄█ ▒█░▄▄ ▒█▀▀▀ 
        //▒█░░▀█ ▒█▄▄▄ ▒█▄▀▄█ 　 ▒█░░▒█ ▒█▄▄▄ ▒█▄▄▄█ ▒█▄▄▄█ ▒█░▒█ ▒█▄▄█ ▒█▄▄▄
        //new message check
        window.last_message_check = function(arg_request) {
            var res = arg_request.split("&&$#((#&&$");
            if (fs(res, 0)) {
                pr(fs(res, 0));
            }
            res = fs(res, 1);
            res = JSON.parse(res);
            console.log(res);

            var obj_last = aih_body.find('.aih_mes_wrap:last');
            var last_message_id = obj_last.attr("data-id");
            var last_message_md5 = obj_last.attr("data-md5");
            var sessionid = fs(res, 'sessionid');
            var cur_sessionid = aih_grand_wrap.attr("data-sessionid");

            if (!last_message_id) { return; }
            if (sessionid != cur_sessionid) { return; }

            var show_retry = fs(res, 'show_retry');
            if (show_retry) {
                aih_grand_wrap.find('.aih_retry_btn').show();
                aih_thinking({ action: 'stop' });
            } else {
                aih_grand_wrap.find('.aih_retry_btn').hide();
            }

            var need_reload = false;

            // Original checks (ID or MD5 changed, or server says reload)
            if (last_message_id != fs(res, 'id')
                || fs(res, 'reload')
                || fs(res, 'md5') != last_message_md5) {
                need_reload = true;
            }

            // NEW CHECK: UI shows thinking, but server has no pending wait
            // This is the fix for the 1% stuck-thinking bug
            if (!need_reload
                && aih_grand_wrap.hasClass('thinking')
                && !fs(res, 'aih_wait')) {
                need_reload = true;
                console.log('[poll] thinking resolved — server aih_wait is empty, forcing reload');
            }

            if (need_reload) {
                aih_grand_wrap.find('.aih_retry_btn').hide();
                aih_upload({ sessionid: sessionid });
            }
        }
        var INTERVAL_MS=3_000;
        var intervalId     =null;
        var lastFiredAt    =null;   // timestamp of the last successful trigger
        var unfocusedAt    =null;   // timestamp of when the tab lost focus
        // ── core action ─────────────────────────────────────────────────────────
        var doWork=function() {
            lastFiredAt=Date.now();
            var sessionid=aih_grand_wrap.attr("data-sessionid");
            console.log('[interval] fired at sessionid:'+sessionid, new Date(lastFiredAt).toISOString());
            
            if(sessionid){
                last_message_checker.find('#sessionid').val(sessionid);
                console.log('s1');
                eval_clicked(last_message_checker.find('[data-eval]'),"");
            }
        }
        // ── interval helpers ────────────────────────────────────────────────────
        var startInterval=function() {
            if (intervalId !== null) return;          // already running
            intervalId=setInterval(doWork, INTERVAL_MS);
        }

        var stopInterval=function() {
            if (intervalId === null) return;
            clearInterval(intervalId);
            intervalId=null;
        }

        // ── visibility / focus handlers ──────────────────────────────────────────
        $(window).on('focus', onFocus);
        $(window).on('blur',  onBlur);

        // Also handle the Page Visibility API (covers tab switches more reliably)
        $(document).on('visibilitychange', function () {
            if (document.hidden) {
                onBlur();
            } else {
                onFocus();
            }
        });
        var onFocus=function() {
            const now         =Date.now();
            const sinceLastRun=lastFiredAt === null ? Infinity : now - lastFiredAt;

            // If the tab was hidden for 10+ seconds (or never fired yet),
            // fire RIGHT NOW instead of making the user wait for the next tick.
            if (sinceLastRun >= INTERVAL_MS) {
                doWork();
            }

            // (Re-)start the regular interval from this moment so the next tick
            // is always a clean 10 s from the last actual run.
            stopInterval();
            startInterval();
        }
        var onBlur=function() {
            unfocusedAt=Date.now();
            stopInterval();   // no wasted calls while the tab is invisible
        }
        // ── kick off on page load ────────────────────────────────────────────────
        // Treat the initial load as a "focus" event.
        onFocus();


        },1);});})(jQuery);</script><?php $css=ob_get_clean();
        return $css;
    }
    /*
    if($act=='button'){
        $code='';
        extract($arr);
        return ['code'=>$code];
        ob_start();?>
        <style>
        .aih_grand_wrap{display:none;}
        body.aih_open .aih_grand_wrap{position:fixed;top:0;max-width:800px;width:100%;height:100%;background:#fff;right:0;z-index:99990;display:block;}
        body.aih_open .aih_bg{background:#474747d4;position:fixed;top:0;width:100%;height:100%;left:0;z-index:1111;}
        body.aih_open{overflow:hidden;}
        .aih_button{position:fixed;bottom:30px;right:30px;width:70px;height:70px;border-radius:200px !important;color:#fff !important;display:flex !important;font-size:30px !important;justify-content:center;align-items:center;cursor:pointer !important;display:block;}
        </style>
        <script>(function($) {"use strict";$(document).ready(function(){setTimeout(function(){
        

        

        },1);});})(jQuery);</script><?php $css=ob_get_clean();
        $code.=$css;
        $code.='<a href="/crm/?page=aih" class="aih_button btn btn-primary"><i class="fa fa-hand-sparkles"></i></a>';
        $code.='<div class="aih_grand_wrap">
        <div class="close"></div>
        <div class="aih_head_in"></div>
        <div class="aih_body_in">
        '.html('loader').'</div>
        <div class="aih_textarea_in"></div>
        </div>';
        $code.='<div class="aih_bg"></div>';
        return ['code'=>$code];
    }*/



}

?>
