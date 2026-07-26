package com.functional.todo;

import org.junit.jupiter.api.*;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;

import java.util.concurrent.TimeUnit;

import static org.assertj.core.api.Assertions.assertThat;


public class TasksTest {
    private WebDriver driver;
    private ListPage listPage;

    private void pause(int secs) {
        try {
            TimeUnit.SECONDS.sleep(secs);
        } catch (InterruptedException e) {
        }
    }

    @BeforeEach
    void setUp() {
        final String url = "localhost:8000";
        driver = new FirefoxDriver();
        driver.get("localhost:8000/?action=test-cleanup-tables");
        //pause(1);
        driver.get(url);
        listPage = new ListPage(driver);
    }

    @AfterEach
    void tearDown() {
        driver.quit();
    }

    @AfterAll
    static void tearDownClass() {
        var driver = new FirefoxDriver();
        driver.get("localhost:8000/?action=test-cleanup-tables");
        driver.quit();
    }

    @DisplayName("Deve redirecionar para pagina tasks Quando criar lista com sucesso.")
    @Test
    public void shouldRedirectToTasksWhenSubmitSuccessfullyOnListPage() {
        var listPage = new ListPage(driver);
        var input = listPage.getListNameInput();
        var submitListNameButton = listPage.getSubmitButton();
        input.sendKeys("Lista de compras");
        submitListNameButton.click();
        assertThat(driver.getPageSource()).containsIgnoringCase("Lista de compras");
        driver.quit();
    }

    @DisplayName("Deve ser possível inserir tarefas Quando abrir a pagina tasks")
    @Test
    public void shouldBePossibleToInsertTasksWhenOnTasksPage() {
        var listPage = new ListPage(driver);
        var listInput = listPage.getListNameInput();
        var listSubmitButton = listPage.getSubmitButton();
        listInput.sendKeys("Lista de compras");
        listSubmitButton.click();

        assertThat(driver.getCurrentUrl()).containsIgnoringCase("todo");
        var tasksPage = new TasksPage(driver);
        var taskInput = tasksPage.getTaskNameInput();
        var taskSubmitButton = tasksPage.getSubmitButton();
        taskInput.sendKeys("Comprar leite");
        taskSubmitButton.click();
        assertThat(driver.getPageSource()).containsIgnoringCase("Comprar leite");
        driver.quit();
    }

    @Test
    void shouldIdAttributeBePresentOnEachTaskWhenCreated() {
        var listPage = new ListPage(driver);
        var listInput = listPage.getListNameInput();
        var listSubmitButton = listPage.getSubmitButton();
        listInput.sendKeys("Lista de compras");
        listSubmitButton.click();

        var tasksPage = new TasksPage(driver);
        var tasksInput = tasksPage.getTaskNameInput();
        var taskSubmitButton = tasksPage.getSubmitButton();
        tasksInput.sendKeys("Comprar leite");
        taskSubmitButton.click();
        var tasksLink = tasksPage.getTasksLinks();
        assertThat(tasksLink.getFirst().getAttribute("href")).containsIgnoringCase("id=1");

    }

    @Test
    void shouldBePossibleToInsertMoreThanOneTaskWhenCreatingTasks() {
        var listPage = new ListPage(driver);
        listPage.createList("Lista de compras");
        var tasks = new TasksPage(driver);

        tasks.createTask("Comprar leite");
        tasks = new TasksPage(driver);
        tasks.createTask("Comprar ovos");

        assertThat(driver.getPageSource()).containsIgnoringCase("Comprar ovos");
        assertThat(driver.getPageSource()).containsIgnoringCase("Comprar leite");
    }

    @Test
    void shouldFindTasksIdSequenceWhenCreatingMultipleTasks() {
        var listPage = new ListPage(driver);
        listPage.createList("Lista de compras");
        TasksPage tasksPage = new TasksPage(driver);
        tasksPage.createTask("Comprar leite");

        tasksPage = new TasksPage(driver);
        tasksPage.createTask("Comprar ovos");

        tasksPage = new TasksPage(driver);
        tasksPage.createTask("Comprar açucar");

        tasksPage = new TasksPage(driver);
        var tasksLinks = tasksPage.getTasksLinks();

        assertThat(tasksLinks.size()).isEqualTo(3);
        for(int i = 1; i < 4; i++) {
            assertThat(tasksLinks.get(i - 1).getAttribute("href")).containsIgnoringCase("action=remove-task&id=" + i);
        }
    }

    @Test
    void shouldBePossibleToRemoveTasksWhenClickOnRemoveButton() {
        listPage.createList("Lista de compras de eletrónicos");
        new TasksPage(driver).createTask("Comprar mouse");
        new TasksPage(driver).createTask("Comprar HD");
        new TasksPage(driver).createTask("Comprar monitor");

        var btn = new TasksPage(driver).getRemoveTasksButton(0);
        btn.click();
        
        new TasksPage(driver).getRemoveTasksButton(0).click();
        new TasksPage(driver).getRemoveTasksButton(0).click();

        assertThat(new TasksPage(driver).getTasksLinks().size()).isEqualTo(0);
    }
}
