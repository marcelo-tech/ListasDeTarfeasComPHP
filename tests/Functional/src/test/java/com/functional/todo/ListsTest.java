package com.functional.todo;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;

import java.util.concurrent.TimeUnit;

import static org.assertj.core.api.Assertions.assertThat;

public class ListsTest {
    private WebDriver driver;

    private void pause(int secs) {
        try {
            TimeUnit.SECONDS.sleep(secs);
        } catch (InterruptedException e) {
        }
    }

    @BeforeEach
    void setUp() {
        driver = new FirefoxDriver();
        driver.get("localhost:8000/?action=test-cleanup-tables");
        driver.get("localhost:8000");
    }

    @AfterEach
    void tearDown() {
        driver.quit();
    }

    @Test
    void shouldExistNavLinkForListsWhenListsPageLoad() {
        new ListPage(driver).createList("Lista de ferramentas");
        var listsPage = new ListsPage(driver);
        var navLinks = listsPage.getNavLinks();
        var newListLink = navLinks.get(0);
        var tasksLink = navLinks.get(1);
        var listsLink = navLinks.get(2);

        assertThat(newListLink.getText()).containsIgnoringCase("Nova Lista");
        assertThat(listsLink.getText()).containsIgnoringCase("Listas");
        assertThat(tasksLink.getText()).containsIgnoringCase("Tarefas");
    }

    @Test
    void shouldHaveListContainerWhenListsPageLoad() {
        driver.get("localhost:8000/?action=lists");
        var listsPage = new ListsPage(driver);
        assertThat(listsPage.getListsContainer().isEnabled()).isTrue();
    }

    @Test
    void shouldHaveTheNamesOfTheListsCreatedWhenListsPageLoad() {
        String  url = "localhost:8000";
        new ListPage(driver).createList("Lista de compras");

        driver.get(url);
        new ListPage(driver).createList("Ingredientes da receita de bolo");

        driver.get(url);
        new ListPage(driver).createList("Peças para concertar no carro");

        driver.get(url + "/?action=lists");
        var listsPage = new ListsPage(driver);
        var listNames = listsPage.getListNames();

        assertThat(listNames.get(0).getText()).containsIgnoringCase("lista de compras");
        assertThat(listNames.get(1).getText()).containsIgnoringCase("Ingredientes da receita de bolo");
        assertThat(listNames.get(2).getText()).containsIgnoringCase("peças para concertar no carro");
    }

    @Test
    void shouldHaveTheNumberOfTasksOnEachListWhenListsExistsOnPage() {
        new ListPage(driver).createList("Lista de compras");
        new TasksPage(driver).createTask("Comprar leite");
        new TasksPage(driver).createTask("Comprar açúcar");
        new TasksPage(driver).createTask("Comprar ovos");

        driver.get("localhost:8000/?action=lists");
        var listsPage = new ListsPage(driver);
        var numberOfTasksPerListParagraphs = listsPage.getNumberOfTasksPerList();
        assertThat(numberOfTasksPerListParagraphs.get(0).getText()).containsIgnoringCase("3");
    }
}
