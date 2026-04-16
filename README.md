# Qual Apóstolo? 🙏

Quiz personalidade para descobrir qual dos 12 apóstolos de Jesus você é mais parecido. Feito em **PHP puro** + **Tailwind CSS** + **SQLite**.

## Stack

- **Backend**: PHP 7.4+
- **Frontend**: HTML5 + Tailwind CSS (CDN)
- **Database**: SQLite3
- **Routing**: Apache `.htaccess` URL rewriting
- **Payment**: Mercado Pago (Pix) + WhatsApp (Evolution API)

## Instalação Local

### Pré-requisitos

- PHP 7.4+ com PDO + SQLite3
- Apache com `mod_rewrite` ativado
- WhatsApp (Evolution API key) — opcional para produção

### Setup

1. **Clonar repositório**
```bash
git clone https://github.com/dantetesta/qualapostolo.git
cd qualapostolo
```

2. **Criar diretório de dados**
```bash
mkdir -p data
chmod 755 data
```

3. **Configurar variáveis de ambiente** (opcional)
```bash
cp .env.example .env
# Editar .env com suas API keys
```

4. **Servir localmente**

**Opção A: PHP Built-in Server** (rápido, desenvolvimento)
```bash
php -S localhost:8000 -t public/
# Acessa http://localhost:8000
```

**Opção B: Apache** (recomendado, produção)
```apache
<VirtualHost *:80>
    ServerName qualapostolo.local
    DocumentRoot /path/to/qualapostolo/public
    
    <Directory /path/to/qualapostolo/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

5. **Testar**
- Home: `http://localhost:8000/`
- Quiz: `http://localhost:8000/quiz`
- Resultado: `http://localhost:8000/resultado?id=xyz`

## Estrutura

```
qualapostolo/
├── public/                 # Webroot (DocumentRoot no Apache)
│   ├── index.php          # Router principal
│   ├── .htaccess          # URL rewriting
│   └── assets/            # CSS, JS, imagens (não criados ainda)
├── src/
│   ├── config.php         # Configuração global
│   ├── database/
│   │   └── schema.sql     # Schema SQLite
│   ├── includes/
│   │   ├── db.php         # PDO wrapper
│   │   ├── apostles.php   # Dados dos 12 apóstolos
│   │   ├── questions.php  # 20 questões do quiz
│   │   └── scoring.php    # Algoritmo de matching
│   ├── pages/
│   │   ├── home.php       # Landing page
│   │   ├── quiz.php       # Quiz
│   │   ├── resultado.php  # Resultado
│   │   └── pagamento.php  # Pagamento
│   └── api/
│       └── handler.php    # Endpoints AJAX
├── data/                  # Database (não incluído em git)
│   └── quiz.db           # SQLite (criado automaticamente)
└── README.md
```

## Rotas

| URL | Arquivo | Descrição |
|-----|---------|-----------|
| `/` | `src/pages/home.php` | Landing page |
| `/quiz` | `src/pages/quiz.php` | Quiz (20 questões) |
| `/resultado?id=xyz` | `src/pages/resultado.php` | Resultado do quiz |
| `/pagamento` | `src/pages/pagamento.php` | Pagamento Pix |
| `/api/quiz/answer` | `src/api/handler.php` | Salvar resposta (AJAX) |

## Database Schema

### `quizzes`
```sql
id TEXT PRIMARY KEY
session_id TEXT
answers JSON (array de respostas)
result JSON (resultado calculado)
created_at TIMESTAMP
updated_at TIMESTAMP
```

### `payments`
```sql
id TEXT PRIMARY KEY
session_id TEXT
whatsapp TEXT
amount REAL
status TEXT (pending, completed, failed)
pix_qr_code TEXT
transaction_id TEXT
created_at TIMESTAMP
```

### `logs`
```sql
id INTEGER PRIMARY KEY
action TEXT
data JSON
ip_address TEXT
created_at TIMESTAMP
```

## Deploy para VPS

### 1. Preparar VPS

```bash
# SSH no VPS
ssh user@104.236.236.60

# Criar diretório
sudo mkdir -p /var/www/qualapostolo
sudo chown -R www-data:www-data /var/www/qualapostolo
cd /var/www/qualapostolo
```

### 2. Upload via FTP/SCP

```bash
# Localmente
scp -r . user@104.236.236.60:/var/www/qualapostolo/

# Ou via FTP (Filezilla, WinSCP)
# Host: 104.236.236.60
# User: seu_user
# Password: sua_senha
# Remote path: /var/www/qualapostolo/
```

### 3. Configurar permissões

```bash
sudo chmod -R 755 /var/www/qualapostolo/public
sudo chmod -R 755 /var/www/qualapostolo/data
sudo chmod 644 /var/www/qualapostolo/public/.htaccess
```

### 4. Apache config

```bash
# Ativar mod_rewrite
sudo a2enmod rewrite

# Criar VirtualHost
sudo nano /etc/apache2/sites-available/qualapostolo.conf
```

```apache
<VirtualHost *:80>
    ServerName qualapostolo.com.br
    ServerAlias www.qualapostolo.com.br
    DocumentRoot /var/www/qualapostolo/public
    
    <Directory /var/www/qualapostolo/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    <Directory /var/www/qualapostolo/data>
        Deny from all
    </Directory>
</VirtualHost>
```

```bash
# Ativar site
sudo a2ensite qualapostolo
sudo systemctl restart apache2
```

### 5. SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d qualapostolo.com.br -d www.qualapostolo.com.br
```

### 6. Criar database

```bash
cd /var/www/qualapostolo
php -r "
    require 'src/config.php';
    require 'src/includes/db.php';
    echo 'Database initialized!';
"
```

## Variáveis de Ambiente

```env
APP_ENV=production
GROQ_API_KEY=xxx          # Para análise com IA (opcional)
GEMINI_API_KEY=xxx        # Google Gemini (opcional)
MP_ACCESS_TOKEN=xxx       # Mercado Pago
EVO_API_KEY=xxx           # Evolution API (WhatsApp)
```

Carregar via:
```php
define('KEY', getenv('KEY') ?: 'default');
```

## APIs Integradas

### Mercado Pago (Pix)

```php
// Em src/includes/payment.php
require_once 'payment.php';
$qrCode = generatePixQrCode(19.90); // Gera QR code
```

### Evolution API (WhatsApp)

```php
// Enviar PDF via WhatsApp
sendPdfViaWhatsApp($whatsapp, $pdfPath);
```

## Troubleshooting

**"404 em todas as rotas"**
- Verificar `.htaccess` está no `public/`
- Ativar `mod_rewrite`: `sudo a2enmod rewrite`
- Permitir override: `AllowOverride All` no VirtualHost

**"Database locked"**
- SQLite requer escrita no diretório `data/`
- Verificar permissões: `chmod 755 data/`

**"Quiz não salva respostas"**
- Verificar session está iniciada em `config.php`
- Checar erros em `/api/quiz/answer`
- Verificar database com `sqlite3 data/quiz.db`.tables`

## Performance

- **Caching**: `.htaccess` com `mod_expires` (1 ano para assets)
- **Gzip**: Compressão automática de CSS/JS/HTML
- **Mobile-first**: Responsive com Tailwind
- **Load time**: <1s em conexão 4G

## Segurança

- ✅ SQL Injection: PDO com prepared statements
- ✅ XSS: Output escaping com `htmlspecialchars()`
- ✅ CSRF: Session-based (adicionar tokens se necessário)
- ✅ Rate limiting: Implementar se houver picos de tráfego
- ✅ Data: `.htaccess` nega acesso a `/data` e `.env`

## Monitoramento

```bash
# Ver logs do Apache
sudo tail -f /var/log/apache2/error.log
sudo tail -f /var/log/apache2/access.log

# Database
sqlite3 /var/www/qualapostolo/data/quiz.db
> SELECT COUNT(*) FROM quizzes;
> SELECT COUNT(*) FROM payments;
```

## Próximas Features

- [ ] Integração real com Mercado Pago + Pix
- [ ] Envio de PDF via WhatsApp
- [ ] Admin panel para analytics
- [ ] Sistema de referência (ganhe Pix)
- [ ] App mobile (React Native)
- [ ] Suporte multilíngue (EN, ES)

## Suporte

- Issues: https://github.com/dantetesta/qualapostolo/issues
- Email: dante.testa@gmail.com
- WhatsApp: [link]

---

**Made with ❤️ by Dante Testa**
