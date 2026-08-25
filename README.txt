# Calc Pred Eng

Plugin WordPress desenvolvido para realizar uma **estimativa preliminar de viabilidade construtiva** de um empreendimento.

O Calc Pred Eng utiliza informações do terreno e características desejadas para o edifício para estimar áreas, quantidade de apartamentos, vagas de estacionamento, custo da obra e outros indicadores preliminares.

Além dos cálculos realizados no navegador, os dados podem ser enviados para a integração da WGB Engenharia para processamento e geração do documento correspondente.

---

## Funcionalidades

- Cálculo preliminar de viabilidade construtiva.
- Entrada das dimensões do terreno.
- Configuração da quantidade de pavimentos.
- Configuração dos pavimentos de garagem.
- Definição da quantidade de dormitórios.
- Definição da quantidade de banheiros.
- Definição da quantidade de lavabos.
- Definição da quantidade de sacadas.
- Configuração de elevadores.
- Seleção do padrão construtivo.
- Cálculo de recuos.
- Estimativa da área disponível para construção.
- Estimativa da área dos apartamentos.
- Estimativa da quantidade de apartamentos.
- Estimativa da quantidade de vagas.
- Estimativa da área total do empreendimento.
- Estimativa da área privativa.
- Estimativa do custo da obra.
- Estimativa do custo por unidade.
- Envio dos dados para integração externa.
- Geração e visualização do PDF resultante.
- Proteção contra múltiplos envios consecutivos.
- Atualização do plugin através do GitHub.

---

## Como funciona

O usuário informa as características básicas do terreno e do empreendimento desejado.

O plugin utiliza esses valores para realizar uma estimativa preliminar.

```text
Dados do Cliente
       +
Dados do Terreno
       +
Características do Empreendimento
       |
       v
Calc Pred Eng
       |
       v
Cálculos de Viabilidade
       |
       v
Resultados
       |
       v
Integração WGB
       |
       v
PDF
```

Os cálculos são realizados no navegador através do JavaScript do plugin.

Após o processamento, os dados também podem ser enviados para a integração configurada pela WGB Engenharia.

---

## Dados Solicitados

### Contato

O formulário solicita:

- Nome.
- E-mail.
- WhatsApp.

Esses campos são obrigatórios para o envio do projeto.

### Terreno

São utilizadas informações como:

- Largura do terreno.
- Profundidade do terreno.

### Empreendimento

O usuário pode informar:

- Pavimentos de garagem.
- Andares com apartamentos.
- Quantidade de dormitórios.
- Quantidade de banheiros.
- Quantidade de lavabos.
- Sacadas por apartamento.
- Elevadores por andar.

### Padrão Construtivo

O plugin permite selecionar o padrão construtivo:

```text
Normal
Médio
Alto
```

O padrão selecionado influencia a estimativa de custo utilizada pelo cálculo.

---

## Resultados

Com base nas informações fornecidas, o Calc Pred Eng calcula diferentes indicadores do empreendimento.

Entre eles:

- Número total de pavimentos.
- Área de escadas.
- Recuo lateral.
- Recuo de fundos.
- Ocupação máxima por pavimento.
- Área de embasamento.
- Área disponível para estacionamento.
- Quantidade estimada de vagas.
- Largura útil do terreno.
- Profundidade útil do terreno.
- Área da laje dos pavimentos tipo.
- Área ocupada pelos elevadores.
- Área útil dos apartamentos.
- Tamanho estimado dos apartamentos.
- Apartamentos por andar.
- Quantidade total de apartamentos.
- Área total construída.
- Área total do empreendimento.
- Área privativa.
- Coeficiente privativo.
- Estimativa de custo da obra.
- Estimativa de custo por unidade.

---

## Regras de Entrada

Alguns campos possuem valores mínimos.

Caso seja informado um valor abaixo do permitido, o plugin pode ajustá-lo automaticamente para o mínimo definido.

Exemplos utilizados pelo formulário:

| Campo | Mínimo |
|---|---:|
| Largura do terreno | 3 |
| Profundidade do terreno | 10 |
| Pavimentos de garagem | 1 |
| Andares com apartamentos | 2 |
| Dormitórios | 1 |
| Banheiros | 1 |
| Lavabos | 0 |
| Sacadas | 0 |
| Elevadores | 0 |

O sistema também possui limite para a quantidade total de pavimentos de acordo com os parâmetros utilizados pelo cálculo.

---

## Aviso sobre os Resultados

> Os resultados fornecidos pelo Calc Pred Eng são estimativas preliminares e não substituem estudos técnicos, projetos, análises legais ou verificações realizadas por profissionais habilitados.

Os valores calculados dependem dos parâmetros configurados no plugin e das informações fornecidas pelo usuário.

---

## Instalação

### 1. Acesse a pasta de plugins do WordPress

Exemplo:

```bash
cd /opt/apps/wordpress/wp-content/plugins
```

O caminho pode variar dependendo da instalação do WordPress.

### 2. Clone o repositório

```bash
git clone https://github.com/gitimmhub/calc-pred-eng.git
```

Será criada a pasta:

```text
wp-content/plugins/calc-pred-eng/
```

### 3. Ative o plugin

No painel administrativo do WordPress:

```text
Plugins
→ Plugins instalados
→ Calc Pred Eng
→ Ativar
```

---

## Adicionando a Calculadora em uma Página

Crie ou edite uma página no WordPress.

Adicione o shortcode:

```text
[calc-pred-eng]
```

Depois publique ou atualize a página.

A calculadora será renderizada automaticamente no local onde o shortcode foi inserido.

---

## Fluxo de Utilização

O fluxo normal é:

```text
1. Usuário acessa a página
        ↓
2. Preenche os dados pessoais
        ↓
3. Informa as dimensões do terreno
        ↓
4. Configura o empreendimento
        ↓
5. Seleciona o padrão construtivo
        ↓
6. Clica em "Gerar Projeto"
        ↓
7. Calc Pred Eng realiza os cálculos
        ↓
8. Dados são enviados para a integração
        ↓
9. Documento é processado
        ↓
10. PDF fica disponível
```

---

## Integração

Após realizar os cálculos, o plugin monta uma estrutura contendo os dados fornecidos e os resultados calculados.

Entre as informações enviadas estão:

```text
Cliente
├── Nome
├── E-mail
└── WhatsApp

Entrada
├── Terreno
├── Pavimentos
├── Garagens
├── Ambientes
├── Elevadores
└── Padrão construtivo

Resultados
├── Áreas
├── Recuos
├── Vagas
├── Apartamentos
├── Área privativa
├── Área construída
├── Custo da obra
└── Custo por unidade
```

Essas informações são enviadas para o serviço de integração configurado pelo projeto.

---

## Geração do PDF

Quando a integração processa a solicitação corretamente, o plugin disponibiliza a opção:

```text
Baixar PDF
```

O documento retornado pela integração pode então ser aberto pelo navegador.

---

## Proteção Contra Envios Repetidos

O Calc Pred Eng possui uma proteção simples contra múltiplos envios realizados em um intervalo muito curto.

Após um envio, o navegador registra o horário da solicitação.

Caso uma nova tentativa seja realizada antes do intervalo permitido, o usuário recebe um aviso solicitando que aguarde alguns segundos.

Essa proteção ajuda a evitar múltiplas solicitações acidentais.

---

## Estrutura do Plugin

A estrutura principal é:

```text
calc-pred-eng/
│
├── plugin-update-checker/
│
├── calc-pred-eng.php
├── script.js
├── style.css
└── README.md
```

### `calc-pred-eng.php`

Arquivo principal do plugin.

Responsável por:

- Registrar o plugin no WordPress.
- Carregar CSS e JavaScript.
- Registrar o shortcode.
- Criar a estrutura HTML da calculadora.
- Registrar funcionalidades administrativas.
- Configurar o sistema de atualização.

### `script.js`

Responsável pela lógica da calculadora.

Contém:

- Leitura dos dados do formulário.
- Validação dos valores.
- Cálculos.
- Exibição dos resultados.
- Formatação do WhatsApp.
- Controle de envio.
- Comunicação com a integração.
- Tratamento do PDF retornado.

### `style.css`

Responsável pela aparência da calculadora e adaptação da interface para diferentes tamanhos de tela.

### `plugin-update-checker/`

Biblioteca responsável pela verificação de novas versões através do GitHub.

---

## Atualizações

O Calc Pred Eng utiliza o **Plugin Update Checker** para verificar novas versões publicadas no GitHub.

Repositório:

```text
https://github.com/gitimmhub/calc-pred-eng
```

Branch utilizada:

```text
main
```

Quando uma versão superior estiver disponível, o WordPress poderá apresentar a atualização na área de plugins.

---

## Publicando uma Nova Versão

### 1. Atualize a versão

No arquivo:

```text
calc-pred-eng.php
```

altere:

```php
Version: X.Y.Z
```

para a nova versão.

Exemplo:

```php
Version: 2.1.4
```

### 2. Confira as alterações

```bash
git status
```

### 3. Adicione os arquivos

```bash
git add .
```

### 4. Faça o commit

```bash
git commit -m "Versão 2.1.4"
```

### 5. Envie para o GitHub

```bash
git push origin main
```

Após o envio, o sistema de atualização poderá identificar a nova versão.

---

## Checklist Antes de Publicar

Antes de publicar uma nova versão:

- [ ] Atualizar o número da versão.
- [ ] Testar o carregamento da calculadora.
- [ ] Testar campos obrigatórios.
- [ ] Testar valores mínimos.
- [ ] Testar largura e profundidade.
- [ ] Testar quantidade de pavimentos.
- [ ] Testar garagens.
- [ ] Testar dormitórios.
- [ ] Testar banheiros.
- [ ] Testar lavabos.
- [ ] Testar sacadas.
- [ ] Testar elevadores.
- [ ] Testar os padrões construtivos.
- [ ] Conferir os resultados calculados.
- [ ] Testar envio para a integração.
- [ ] Testar geração do PDF.
- [ ] Testar botão de PDF.
- [ ] Conferir o console do navegador.
- [ ] Testar em desktop.
- [ ] Testar em dispositivo móvel.
- [ ] Realizar commit.
- [ ] Realizar push.

---

## Problemas Comuns

### A calculadora não aparece

Verifique:

- Se o plugin está ativo.
- Se o shortcode está correto.
- Se a página contém `[calc-pred-eng]`.
- Se existem erros PHP no WordPress.

---

### O botão "Gerar Projeto" não funciona

Verifique:

- Console do navegador.
- Se `script.js` foi carregado.
- Se os campos obrigatórios foram preenchidos.
- Se os valores informados são válidos.

No navegador:

```text
F12
→ Console
```

---

### Os resultados não são gerados

Verifique se os valores informados respeitam as regras da calculadora.

Também verifique se a quantidade total de pavimentos ultrapassou o limite definido nos parâmetros.

---

### O projeto é calculado, mas não é enviado

Abra:

```text
F12
→ Network
```

Verifique a requisição realizada para o serviço de integração.

Confirme:

- Status HTTP.
- Resposta do servidor.
- Disponibilidade do serviço de integração.
- Erros apresentados no Console.

---

### O PDF não aparece

Verifique:

- Se a integração respondeu com sucesso.
- Se a resposta contém um documento válido.
- Se o navegador permite abrir uma nova aba.
- Se ocorreram erros na requisição.

---

### A atualização não aparece no WordPress

Verifique:

- Se a nova versão é superior à instalada.
- Se a alteração foi enviada para a `main`.
- Se o servidor consegue acessar o GitHub.
- Se o `plugin-update-checker` está presente.
- Se a versão foi alterada no cabeçalho do plugin.

---

## Segurança

Ao desenvolver ou publicar alterações:

- Não coloque senhas no GitHub.
- Não coloque tokens no repositório.
- Não coloque API Keys no código.
- Não utilize dados pessoais reais em arquivos de teste versionados.
- Valide e sanitize dados recebidos pelo WordPress.
- Utilize HTTPS para integrações externas.
- Não exponha informações internas desnecessárias ao navegador.

---

## Repositório

Código-fonte:

```text
https://github.com/gitimmhub/calc-pred-eng
```

---

## Versão

Versão atual analisada:

```text
2.1.3
```

---

## Autor

**Matheus Barbiéri**