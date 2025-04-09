import { test, expect } from '@playwright/test'

test('ホーム画面でタイマーが動くことを確認', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000')

    // スタートボタンを確認
    const startButton = page.getByRole('button', { name: 'スタート' })
    await expect(startButton).toBeVisible()

    // スタートボタンをクリック
    await startButton.click()

    // タイマーがカウントダウンしていることを確認（数秒待ってから）
    await page.waitForTimeout(3000) // 3秒待機
    const timerText = await page.locator('div.text-6xl').innerText()
    expect(timerText).not.toBe('10:00')
})
