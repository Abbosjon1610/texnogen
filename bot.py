from aiogram import Bot, Dispatcher, types
from aiogram.utils import executor

TOKEN = "7706525404:AAHNjlc-30iylGDfUSnvtFoNo_fp-08gGIQ"
WEBAPP_URL = "https://texnogenweb.netlify.app/index.html"

bot = Bot(token=TOKEN)
dp = Dispatcher(bot)

@dp.message_handler(commands=['start'])
async def start(message: types.Message):
    keyboard = types.ReplyKeyboardMarkup(resize_keyboard=True)
    web_app = types.WebAppInfo(url=WEBAPP_URL)
    button = types.KeyboardButton("WebApp'ni ochish", web_app=web_app)
    keyboard.add(button)
    
    await message.answer("WebApp'ni ochish uchun tugmani bosing:", reply_markup=keyboard)

@dp.message_handler(content_types=types.ContentType.WEB_APP_DATA)
async def webapp_data(message: types.Message):
    await message.answer(f"Sizdan ma'lumot keldi: {message.web_app_data.data}")

if __name__ == "__main__":
    from aiogram import executor
    executor.start_polling(dp)
