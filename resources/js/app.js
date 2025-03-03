import { createApp } from 'vue';
import Table from './components/Table.vue';
import Form from './components/Form.vue';
import Button from './components/Button.vue';
import Timer from './components/Timer.vue';
import Shuffle from './components/Shuffle.vue';
import App from './Pages/Tasks/Index.vue';

const app = createApp(App);
app.component('Table', Table);
app.component('Form', Form);
app.component('Button', Button);
app.component('Timer', Timer);
app.component('Shuffle', Shuffle);
app.mount('#app');
