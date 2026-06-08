<?php
/**
 * Plugin Name: Calc Pred Eng
 * Plugin URI: https://github.com/gitimmhub/calc-pred-eng
 * Description: Calculadora de viabilidade construtiva.
 * Version: 1.1
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

            <div class="aviso-minimo">
                Valores abaixo do mínimo serão convertidos automaticamente.
            </div>

            <div class="calculadora-form">

                <div class="campo-nome campo-contato">
                    <label>Nome</label>

                    <div class="input-icon">
                        <span>👤</span>
                        <input type="text" id="nome" placeholder="Seu nome" required>
                    </div>
                </div>

                <div class="campo-email campo-contato">
                    <label>Email</label>

                    <div class="input-icon">
                        <span>✉️</span>
                        <input type="email" id="email" placeholder="seuemail@email.com" required>
                    </div>
                </div>

                <div class="campo-whatsapp campo-contato">
                    <label>WhatsApp</label>

                    <div class="input-icon">
                        <span>📱</span>
                        <input type="text" id="whatsapp" placeholder="(47) 99999-9999" required>
                    </div>
                </div>

                <div class="campo-largura">
                    <label>Largura do Terreno</label>
                    <input type="number" min="3" placeholder="Min = 3">
                </div>

                <div class="campo-profundidade">
                    <label>Profundidade do Terreno</label>
                    <input type="number" min="10" placeholder="Min = 10">
                </div>

                <div class="campo-garagem">
                    <label>Pavimentos de Garagem</label>
                    <input type="number" min="1" placeholder="Min = 1">
                </div>

                <div class="campo-andares">
                    <label>Andares com apartamentos</label>
                    <input type="number" min="2" placeholder="Min = 2">
                </div>

                <div class="campo-dormitorios">
                    <label>Quantidade de Dormitórios</label>
                    <input type="number" min="1" placeholder="Min = 1">
                </div>

                <div class="campo-banheiros">
                    <label>Quantidade de Banheiros</label>
                    <input type="number" min="1" placeholder="Min = 1">
                </div>

                <div class="campo-lavabos">
                    <label>Quantidade de Lavabo</label>
                    <input type="number" min="0" placeholder="Min = 0">
                </div>

                <div class="campo-sacadas">
                    <label>Sacadas por Apartamento</label>
                    <input type="number" min="0" placeholder="Min = 0">
                </div>

                <div class="campo-elevador">
                    <label>Elevadores por Andar</label>
                    <input type="number" min="0" placeholder="Min = 0">
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

            </div>



            <!-- FOOTER -->
            <div class="calculadora-footer">

                <!-- BOTÃO -->
                <div class="acoes">

                    <button id="btn-enviar">
                        Gerar Projeto
                    </button>

                    <button id="btn-pdf" style="display:none;">
                        Baixar PDF
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


    <div id="modal-sucesso" style="display:none;">
        <div class="modal-content">

            <div class="modal-icone">✓</div>

            <h2 class="modal-titulo">Projeto enviado com sucesso!</h2>

            <p class="modal-texto">
                Em breve um especialista da <strong>WGB Arquitura e Engenharia</strong> entrará em contato com você.
            </p>

            <button id="fechar-modal">Fechar</button>

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

    $nome = sanitize_text_field($dados['nome'] ?? '');
    $email = sanitize_email($dados['email'] ?? '');
    $whatsapp = sanitize_text_field($dados['whatsapp'] ?? '');

    if (empty($nome) || empty($email) || empty($whatsapp)) {

        wp_send_json_error([
                'message' => 'Preencha todos os campos obrigatórios.'
        ], 400);

    }

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

