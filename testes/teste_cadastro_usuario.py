# Importa a biblioteca principal do Selenium para controlar o navegador
from selenium import webdriver

# Importa a classe By, usada para localizar elementos (ID, NAME, XPATH, etc)
from selenium.webdriver.common.by import By

# Importa a classe Select, usada para manipular campos <select> (dropdown)
from selenium.webdriver.support.ui import Select

# Importa recurso de espera explícita (espera até que uma condição seja atendida)
from selenium.webdriver.support.ui import WebDriverWait

# Importa condições para WebDriverWait (ex: esperar elemento, alerta, visibilidade)
from selenium.webdriver.support import expected_conditions as EC

# Biblioteca padrão do Python para pausas manuais
import time


# Configuração do webdriver
driver = webdriver.Chrome()  # Abre o Chrome controlado pelo Selenium
driver.maximize_window()  # Maximiza a janela


# === LOGIN ===
# Abre a página de login do sistema
driver.get("http://localhost:8080/GePadariaMbembe/view/index.php")

# Preenche e-mail e senha
time.sleep(2)  # Pausa de 2 segundos
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email"))).send_keys("admin@gmail.com")  # Preenche e-mail
time.sleep(2)  # Pausa de 2 segundos
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "senha"))).send_keys("admin123")  # Preenche senha
time.sleep(2)  # Pausa de 2 segundos

# Clica no botão "Entrar"
driver.find_element(By.ID, "btn-entrar").click()
time.sleep(1)  # Pausa rápida

# Espera o alerta aparecer (confirmação/login inválido) e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert
alert.accept()


# Abre a página de usuários
driver.get("http://localhost:8080/GePadariaMbembe/view/usuarios.php")
time.sleep(3)  # Espera a página carregar


# 1. Clica no botão "Cadastrar Usuários"
cadastrar_btn = driver.find_element(By.XPATH, "//button[contains(text(),'Cadastrar Usuários')]")  # Localiza o botão
cadastrar_btn.click()  # Clica no botão
time.sleep(3)  # Pausa para abrir o formulário


# 2. Preenche o formulário do popup
driver.find_element(By.NAME, "nome").send_keys("Mokelinho da Silva")  # Nome do usuário
time.sleep(1)
driver.find_element(By.NAME, "senha").send_keys("senha123")  # Senha
time.sleep(1)
driver.find_element(By.NAME, "email").send_keys("mokele.teste@example.com")  # E-mail
time.sleep(1)
driver.find_element(By.NAME, "cpf").send_keys("12345678900")  # CPF
time.sleep(1)

# Seleciona o cargo no campo dropdown
cargo_select = Select(driver.find_element(By.NAME, "cargo"))
cargo_select.select_by_visible_text("Administrador")  # Escolhe "Administrador"
time.sleep(3)  # Dá um tempo extra


# 3. Clica no botão "Salvar"
salvar_btn = driver.find_element(By.XPATH, "//button[contains(text(),'Salvar')]")  # Localiza o botão
salvar_btn.click()  # Clica para salvar

# Dá um tempo para o cadastro ser processado
time.sleep(5)


# 4. Verifica se o novo usuário aparece na tabela
tabela = driver.find_element(By.TAG_NAME, "tbody")  # Pega o corpo da tabela
linhas = tabela.find_elements(By.TAG_NAME, "tr")  # Lista todas as linhas

usuario_encontrado = False  # Flag para verificar se encontrou
for linha in linhas:
    # Verifica se o nome e o e-mail aparecem na linha da tabela
    if "Mokelinho da Silva" in linha.text and "mokele.teste@exemplo.com" in linha.text:
        usuario_encontrado = True
        break

# Mostra o resultado do teste no console
if usuario_encontrado:
    print("Teste passou: usuário cadastrado com sucesso!")
else:
    print("Teste falhou: usuário não encontrado na tabela.")

time.sleep(2)


# Espera o alerta aparecer (confirmação ou erro) e clica em "OK"
WebDriverWait(driver, 10).until(EC.alert_is_present())
alert = driver.switch_to.alert
alert.accept()


# Fecha o navegador
time.sleep(5)
driver.quit()
