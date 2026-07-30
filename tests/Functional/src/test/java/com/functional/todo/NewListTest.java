package com.functional.todo;

import java.util.concurrent.TimeUnit;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertTrue;
import static org.junit.jupiter.api.Assertions.assertFalse;

import org.junit.jupiter.api.*;

import static org.assertj.core.api.Assertions.assertThat;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;

//@TestInstance(TestInstance.Lifecycle.PER_CLASS)
public class NewListTest {
    private WebDriver driver;

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
    }

    @AfterEach
    void tearDown() {
        driver.quit();
    }

    @AfterAll
    static  void tearDownClass() {
        var driver = new FirefoxDriver();
        driver.get("localhost:8000/?action=test-cleanup-tables");
        driver.quit();
    }

    @Test
    public void shouldHaveBasicElementsWhenPageRequested() {
        var listPage = new NewListPage(driver);
        assertThat(listPage.getHead().isEnabled()).isTrue();
        assertThat(listPage.getBootstrapCSS().getAttribute("href")).contains("/css/bootstrap.min.css");
        assertThat(listPage.getHeader().isEnabled()).isTrue();
        assertThat(listPage.getMain().isEnabled()).isTrue();
        assertThat(listPage.getFooter().isEnabled()).isTrue();
        assertThat(listPage.getTitle().isEnabled()).isTrue();
        assertThat(driver.getPageSource()).containsIgnoringCase("<title>List</title>");
    }

    @Test
    public void shouldHaveFormToCreateNewListWhenPageRequested() {
        var listPage = new NewListPage(driver);
        assertThat(listPage.getNewListForm().isEnabled()).isTrue();
        assertThat(listPage.getListNameInput().isEnabled()).isTrue();
        assertThat(listPage.getSubmitButton().isEnabled()).isTrue();
        var input = listPage.getListNameInput();
        input.sendKeys("Lista de compras");
        var submit = listPage.getSubmitButton();
        submit.click();
        assertThat(driver.getPageSource()).containsIgnoringCase("lista de compras");
    }

}