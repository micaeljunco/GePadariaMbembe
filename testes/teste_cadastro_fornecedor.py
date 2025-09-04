# Importa a biblioteca principal do Selenium para controlar o navegador
from selenium import webdriver

# Importa a classe By, usada para localizar elementos (por ID, NAME, XPATH, etc)
from selenium.webdriver.common.by import By

# Importa o recurso de espera explícita (aguardar até algo acontecer)
from selenium.webdriver.support.ui import WebDriverWait

# Importa condições pré-definidas para usar com WebDriverWait (ex: esperar elemento aparecer)
from selenium.webdriver.support import expected_conditions as EC

# Biblioteca padrão do Python para pausas manuais
import time


# Cria uma instância do navegador Chrome
driver = webdriver.Chrome()

# Maximiza a janela do navegador
driver.maximize_window()


try:
    # === LOGIN ===
    time.sleep(2)  # Pausa de 2 segundos
    driver.get("http://localhost:8080/GePadariaMbembe/view/index.php")  # Abre a página de login
    time.sleep(2)  # Pausa de 2 segundos

    time.sleep(2)  # Pausa de 2 segundos
    # Espera até que o campo de email esteja presente e insere o valor
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "email"))
    ).send_keys("admin@gmail.com")
    time.sleep(2)  # Pausa de 2 segundos

    time.sleep(2)  # Pausa de 2 segundos
    # Espera até que o campo de senha esteja presente e insere o valor
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "senha"))
    ).send_keys("admin123")
    time.sleep(2)  # Pausa de 2 segundos

    time.sleep(2)  # Pausa de 2 segundos
    driver.find_element(By.ID, "btn-entrar").click()  # Clica no botão de entrar
    time.sleep(2)  # Pausa de 2 segundos

    # Trata alerta de login (se houver)
    try:
        time.sleep(2)  # Pausa de 2 segundos
        WebDriverWait(driver, 5).until(EC.alert_is_present())  # Espera se algum alerta aparecer
        driver.switch_to.alert.accept()  # Aceita o alerta
        time.sleep(2)  # Pausa de 2 segundos
    except:
        pass  # Se não houver alerta, continua normalmente

    # === NAVEGAR PARA FORNECEDORES ===
    def abrir_fornecedores():
        time.sleep(2)  # Pausa de 2 segundos
        driver.get("http://localhost:8080/GePadariaMbembe/view/fornecedores.php")  # Tenta abrir a página de fornecedores
        time.sleep(2)  # Pausa de 2 segundos
        try:
            # Verifica se o título da página corresponde à Gestão de Fornecedores
            WebDriverWait(driver, 5).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(.,'Gestão de Fornecedores')]"))
            )
            return  # Se encontrou, sai da função
        except:
            # Se não encontrou, tenta abrir uma URL alternativa
            time.sleep(2)  # Pausa de 2 segundos
            driver.get("http://localhost:8080/GePadariaMbembe/view/fornecedor.php")
            time.sleep(2)  # Pausa de 2 segundos
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(.,'Gestão de Fornecedores')]"))
            )

    abrir_fornecedores()  # Chama a função para abrir a tela de fornecedores

    # === ABRIR O <dialog> DE CADASTRO ===
    time.sleep(2)  # Pausa de 2 segundos
    # Espera até que o botão de "Cadastrar Fornecedores" esteja presente
    btn_open = WebDriverWait(driver, 15).until(
        EC.presence_of_element_located((By.XPATH, "//button[contains(normalize-space(),'Cadastrar Fornecedores')]"))
    )
    # Faz rolagem até o botão ficar visível na tela
    driver.execute_script("arguments[0].scrollIntoView({block:'center'});", btn_open)
    # Clica no botão usando JavaScript
    driver.execute_script("arguments[0].click();", btn_open)
    time.sleep(2)  # Pausa de 2 segundos

    # Garante que o dialog ficou visível na tela
    WebDriverWait(driver, 10).until(
        EC.visibility_of_element_located((By.ID, "cadastroFornecedores"))
    )

    # === PREENCHER CAMPOS ===
    time.sleep(2)  # Pausa de 2 segundos
    driver.find_element(By.ID, "nomeFornecedor").send_keys("Fornecedor Teste")  # Preenche o nome do fornecedor
    time.sleep(2)  # Pausa de 2 segundos
    driver.find_element(By.ID, "cnpjFornecedor").send_keys("33.637.069/0001-80")  # Preenche o CNPJ
    time.sleep(2)  # Pausa de 2 segundos
    driver.find_element(By.ID, "descFornecedor").send_keys("Fornecedor de Farinha de Rosca")  # Preenche a descrição
    time.sleep(2)  # Pausa de 2 segundos
    driver.find_element(By.ID, "telFornecedor").send_keys("(21) 98765-4321")  # Preenche o telefone
    time.sleep(2)  # Pausa de 2 segundos

    # === ENVIAR FORMULÁRIO ===
    # Localiza o botão de cadastrar dentro do dialog
    btn_submit = driver.find_element(
        By.XPATH, "//dialog[@id='cadastroFornecedores']//button[@type='submit' or text()='Cadastrar']"
    )
    time.sleep(2)  # Pausa de 2 segundos
    driver.execute_script("arguments[0].click();", btn_submit)  # Clica no botão de cadastrar via JavaScript
    time.sleep(2)  # Pausa de 2 segundos

    # Espera até que o dialog desapareça (cadastro enviado)
    WebDriverWait(driver, 10).until(
        EC.invisibility_of_element_located((By.ID, "cadastroFornecedores"))
    )

    # === VALIDAÇÃO SIMPLES: NOME NA TABELA ===
    time.sleep(2)  # Pausa de 2 segundos
    # Verifica se o fornecedor cadastrado aparece na tabela
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//table//td[contains(.,'Fornecedor Teste Selenium')]"))
    )
    time.sleep(2)  # Pausa de 2 segundos
    print(" Cadastro confirmado na tabela.")  # Exibe mensagem de sucesso

# Caso algum erro ocorra durante o teste
except Exception as e:
    print(" Erro no teste:", e)

# Finaliza o teste fechando o navegador
finally:
    time.sleep(2)  # Pausa de 2 segundos
    driver.quit()  # Fecha o navegador
