<?php
/**
 * Plugin Name: Calc Pred Eng
 * Plugin URI: https://github.com/gitimmhub/calc-pred-eng
 * Description: Calculadora de viabilidade construtiva.
 * Version: 1.0.1
 * Author: Matheus Barbiéri
 */

require 'plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
        'https://github.com/gitimmhub/calc-pred-eng/',
        __FILE__,
        'calc-pred-eng'
);

$updateChecker->setBranch('main');

if (!defined('ABSPATH')) {
    exit;
}

// CSS
function calculadora_styles() {
//
//    wp_enqueue_style(
//            'calc-pred-eng-style',
//            plugin_dir_url(__FILE__) . 'style.css'
//    );

    wp_enqueue_style(
            'calc-pred-eng-style',
            plugin_dir_url(__FILE__) . 'style.css',
            array(),
            time()
    );
}

add_action('wp_enqueue_scripts', 'calculadora_styles');

// JS
function calculadora_scripts() {

    wp_enqueue_script(
            'calc-pred-eng-script',
            plugin_dir_url(__FILE__) . 'script.js',
            array(),
            time(),
            true
    );

}

add_action('wp_enqueue_scripts', 'calculadora_scripts');

// SHORTCODE
function calculadora_shortcode() {

    ob_start();
    ?>

    <div class="calculadora-wrapper">

        <div class="calculadora-box">
            <!-- FORMULÁRIO -->
            <div class="calculadora-form">

                <div class="campo-largura">
                    <label>Largura do Terreno</label>
                    <input type="number" placeholder="Ex: 40">
                </div>

                <div class="campo-profundidade">
                    <label>Profundidade do Terreno</label>
                    <input type="number" placeholder="Ex: 43">
                </div>

                <div class="campo-garagem">
                    <label>Pavimentos de Garagem</label>
                    <input type="number" placeholder="Ex: 3">
                </div>

                <div class="campo-andares">
                    <label>Andares com apartamentos</label>
                    <input type="number" placeholder="Ex: 25">
                </div>

                <div class="campo-dormitorios">
                    <label>Quantidade de Dormitórios</label>
                    <input type="number" placeholder="Ex: 2">
                </div>

                <div class="campo-banheiros">
                    <label>Quantidade de Banheiros</label>
                    <input type="number" placeholder="Ex: 2">
                </div>

                <div class="campo-lavabos">
                    <label>Quantidade de Lavabo</label>
                    <input type="number" placeholder="Ex: 1">
                </div>

                <div class="campo-sacadas">
                    <label>Sacadas por Apartamento</label>
                    <input type="number" placeholder="Ex: 1">
                </div>

                <div class="campo-elevador">
                    <label>Elevadores por Andar</label>
                    <input type="number" placeholder="Ex: 2">
                </div>

                <div class="campo-cub">

                    <label for="cub-select">
                        Padrão Construtivo
                    </label>

                    <select id="cub-select" name="conversao_cub">

                        <option value="normal">
                            Normal
                        </option>

                        <option value="media">
                            Médio
                        </option>

                        <option value="alta">
                            Alto
                        </option>

                    </select>

                </div>

                <div class="campo-nome">
                    <label>Nome</label>
                    <input type="text" id="nome">
                </div>

                <div class="campo-email">
                    <label>Email</label>
                    <input type="email" id="email">
                </div>

                <div class="campo-whatsapp">
                    <label>WhatsApp</label>
                    <input type="text" id="whatsapp">
                </div>


            </div>



            <!-- FOOTER -->
            <div class="calculadora-footer">

                <!-- BOTÃO -->
                <div class="acoes">

                    <button id="btn-enviar">
                        Gerar Projeto
                    </button>

                </div>

                <!-- RESULTADOS -->
                <div class="resultado-box">

                    <h3>Resultados</h3>

                    <div id="resultado">

                        <p>
                            Os resultados aparecerão aqui.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php

    return ob_get_clean();

}

add_shortcode('calc-pred-eng', 'calculadora_shortcode');

// MENU ADMIN
function calculadora_menu_admin() {

    add_menu_page(
            'Calculadora',
            'Calculadora',
            'manage_options',
            'calc-pred-eng',
            'calculadora_admin_page',
            'dashicons-calculator',
            20
    );

}

add_action('admin_menu', 'calculadora_menu_admin');

// PAGE ADMIN
function calculadora_admin_page() {
    ?>

    <div class="wrap">

        <h1>Calc Pred</h1>

        <p>
            Seu plugin está funcionando.
        </p>

    </div>

    <?php
}

add_action('wp_ajax_calc_pred_eng_send', 'calc_pred_eng_send');
add_action('wp_ajax_nopriv_calc_pred_eng_send', 'calc_pred_eng_send');

function calc_pred_eng_send() {

    $dados = json_decode(file_get_contents('php://input'), true);

    $nome = sanitize_text_field($dados['nome']);
    $email = sanitize_email($dados['email']);
    $whatsapp = sanitize_text_field($dados['whatsapp']);

    $mensagem = "
Novo lead recebido:

Nome: $nome
Email: $email
WhatsApp: $whatsapp
";

    wp_mail(
            'matheustimm02@gmail.com',
            'Novo Lead - Calc Pred Eng',
            $mensagem
    );

    wp_send_json_success(array(
            'message' => 'Email enviado com sucesso!'
    ));
}

