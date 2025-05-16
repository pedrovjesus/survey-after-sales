
# 📊 Survey WhatsApp System

Este projeto é um sistema de **pesquisa automatizada via WhatsApp**. Utiliza a [Z-API](https://www.z-api.io/) para enviar e receber mensagens, permitindo interações com clientes e registro de suas respostas em um banco de dados.

---

## 🚀 Funcionalidades

- Envio automático de perguntas via WhatsApp
- Recebimento e armazenamento das respostas
- Controle de perguntas por cliente
- Finalização automática ao término da pesquisa

---

## 🛠 Tecnologias utilizadas

- **PHP 7+**
- **MySQL**
- **cURL**
- **Z-API**
- **Composer** (para autoload se necessário)
- Servidor local com **XAMPP**, **Apache**, ou via **NGROK** para testes externos

---

## 🔌 Requisitos

- PHP 7.4+
- MySQL
- Conta ativa na Z-API (https://www.z-api.io/)
- Composer (opcional)

---

## ⚙️ Configuração

1. Clone o repositório:

```bash
git clone https://github.com/seu-usuario/survey-whatsapp.git
cd survey-whatsapp
````

2. Crie o arquivo `.env` na raiz e defina suas variáveis:

```env
ZAPI_INSTANCE_ID=SEU_ID_DA_INSTANCIA
ZAPI_CLIENT_TOKEN=SEU_CLIENT_TOKEN
ZAPI_TOKEN=SEU_TOKEN
ZAPI_BASE_URL=https://api.z-api.io
```

3. Crie as tabelas e perguntas:

```sql
php src/migrate.php
```

4. Inicie a pesquisa manualmente com:

```
http://localhost/survey/public/start-survey.php?phone=5511999999999
```

---

## 🔄 Webhook

Configure o webhook da Z-API para apontar para:

```
https://seu-dominio-ou-ngrok.io/survey/public/webhook.php
```

---

## 🧪 Teste

1. Certifique-se de que o número está cadastrado em `customers`.
2. Inicie a pesquisa com `start-survey.php`.
3. Responda no WhatsApp.
4. A resposta será armazenada e a próxima pergunta enviada automaticamente.

---

## 🐛 Debug

Para ver as chamadas feitas ao Z-API, verifique o log gerado por `DebugCurl.php`. Exemplo:

```php
debugCurl($url, $headers, $data, $responseRaw);
```
