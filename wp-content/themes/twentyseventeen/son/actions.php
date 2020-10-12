<?php

    // executa para usuários logados
    add_action("wp_ajax_son_like_action", "son_like_function");

    // executa para usuários não logados
    add_action("wp_ajax_nopriv_son_like_action", "son_like_function");

    function son_like_function() {
        // verifica secret nonce
        if ( !wp_verify_nonce( $_REQUEST['nonce'], "son_user_like_nonce")) {
                exit("ops!!! algo de errado com sua requisição");
            }   
            
            // pesquisa quantidade de curtidas do post
            $like_count = get_post_meta($_REQUEST["post_id"], "likes", true);
            $like_count = ($like_count == '') ? 0 : $like_count;
            $new_like_count = $like_count + 1;
            
            // atualiza quantidade de curtidas do post
            $like = update_post_meta($_REQUEST["post_id"], "likes", $new_like_count);
            
            // checagem de erros
            if($like === false) {
                $result['type'] = "error";
                $result['like_number'] = $like_count;
            }
            else {
                $result['type'] = "success";
                $result['like_number'] = $new_like_count;
            }
            
            // retorno de resultados para frontend
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $result = json_encode($result);
                echo $result;
            }
            else {
                header("Location: ".$_SERVER["HTTP_REFERER"]);
            }

            // sempre finalizar arquivo de script com um die para sua segurança caso tenha alguma falha em sua lógica
            die();
    }
    
    // function son_like_function_priv() {

    // }