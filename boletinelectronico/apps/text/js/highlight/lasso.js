(window.textWebpackJsonp=window.textWebpackJsonp||[]).push([[91],{468:function(e,a){e.exports=function(e){var a="\\]|\\?>",n={literal:"true false none minimal full all void and or not bw nbw ew new cn ncn lt lte gt gte eq neq rx nrx ft",built_in:"array date decimal duration integer map pair string tag xml null boolean bytes keyword list locale queue set stack staticarray local var variable global data self inherited currentcapture givenblock",keyword:"cache database_names database_schemanames database_tablenames define_tag define_type email_batch encode_set html_comment handle handle_error header if inline iterate ljax_target link link_currentaction link_currentgroup link_currentrecord link_detail link_firstgroup link_firstrecord link_lastgroup link_lastrecord link_nextgroup link_nextrecord link_prevgroup link_prevrecord log loop namespace_using output_none portal private protect records referer referrer repeating resultset rows search_args search_arguments select sort_args sort_arguments thread_atomic value_list while abort case else fail_if fail_ifnot fail if_empty if_false if_null if_true loop_abort loop_continue loop_count params params_up return return_value run_children soap_definetag soap_lastrequest soap_lastresponse tag_name ascending average by define descending do equals frozen group handle_failure import in into join let match max min on order parent protected provide public require returnhome skip split_thread sum take thread to trait type where with yield yieldhome"},r=e.COMMENT("\x3c!--","--\x3e",{relevance:0}),t={className:"meta",begin:"\\[noprocess\\]",starts:{end:"\\[/noprocess\\]",returnEnd:!0,contains:[r]}},s={className:"meta",begin:"\\[/noprocess|<\\?(lasso(script)?|=)"},i={className:"symbol",begin:"'[a-zA-Z_][\\w.]*'"},l=[e.C_LINE_COMMENT_MODE,e.C_BLOCK_COMMENT_MODE,e.inherit(e.C_NUMBER_MODE,{begin:e.C_NUMBER_RE+"|(-?infinity|NaN)\\b"}),e.inherit(e.APOS_STRING_MODE,{illegal:null}),e.inherit(e.QUOTE_STRING_MODE,{illegal:null}),{className:"string",begin:"`",end:"`"},{variants:[{begin:"[#$][a-zA-Z_][\\w.]*"},{begin:"#",end:"\\d+",illegal:"\\W"}]},{className:"type",begin:"::\\s*",end:"[a-zA-Z_][\\w.]*",illegal:"\\W"},{className:"params",variants:[{begin:"-(?!infinity)[a-zA-Z_][\\w.]*",relevance:0},{begin:"(\\.\\.\\.)"}]},{begin:/(->|\.)\s*/,relevance:0,contains:[i]},{className:"class",beginKeywords:"define",returnEnd:!0,end:"\\(|=>",contains:[e.inherit(e.TITLE_MODE,{begin:"[a-zA-Z_][\\w.]*(=(?!>))?|[-+*/%](?!>)"})]}];return{aliases:["ls","lassoscript"],case_insensitive:!0,lexemes:"[a-zA-Z_][\\w.]*|&[lg]t;",keywords:n,contains:[{className:"meta",begin:a,relevance:0,starts:{end:"\\[|<\\?(lasso(script)?|=)",returnEnd:!0,relevance:0,contains:[r]}},t,s,{className:"meta",begin:"\\[no_square_brackets",starts:{end:"\\[/no_square_brackets\\]",lexemes:"[a-zA-Z_][\\w.]*|&[lg]t;",keywords:n,contains:[{className:"meta",begin:a,relevance:0,starts:{end:"\\[noprocess\\]|<\\?(lasso(script)?|=)",returnEnd:!0,contains:[r]}},t,s].concat(l)}},{className:"meta",begin:"\\[",relevance:0},{className:"meta",begin:"^#!",end:"lasso9$",relevance:10}].concat(l)}}}}]);
//# sourceMappingURL=lasso.js.map?v=b9c9ac7aa4b7a8a460b4