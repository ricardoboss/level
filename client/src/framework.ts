type StateInterface = Record<string, any>

function updateValues<S extends StateInterface>(state: S): void {
  for (const key of Object.keys(state)) {
    document.querySelectorAll(`[php-value="${key}"]`).forEach((el: Element) => {
      (el as HTMLInputElement).value = state[key];
    })
  }
}

interface MessageInterface<T = any> {
  type: string;
  payload: T;
}

enum MessageType {
  State = 'state',
}

enum ActionType {
  Click = 'click',
  Change = 'change',
}

let socket: WebSocket

export function createApp(address: string) {
  socket = new WebSocket(address)
  socket.addEventListener('open', onOpen)
}

function onOpen(event: Event): void {
  attachListeners()
  socket.addEventListener('message', onMessage)
}

function onMessage(event: MessageEvent): void {
  try {
    const decoded = JSON.parse(event.data)
    if (decoded.hasOwnProperty('type')) {
      const message = decoded as MessageInterface
      onMessageDecoded(message)
    } else {
      console.error("Unknown message format", decoded)
    }
  } catch (e) {
    console.error("Malformed message body", e)
  }
}

function onMessageDecoded(message: MessageInterface): void {
  switch (message.type) {
    case MessageType.State:
      onStateMessage(message)
      break
    default:
      console.error("Unknown message type", message.type)
  }
}

function onStateMessage(message: MessageInterface): void {
  updateValues(message.payload)
}

function onAction(action: ActionType, payload: any): void {
  const encoded = JSON.stringify({
    action,
    payload,
  })

  socket.send(encoded)
}

function attachListeners(): void {
  attachClickListeners();
  attachChangeListeners();
}

function attachClickListeners(): void {
  document.querySelectorAll('[php-click]').forEach((el: Element) => {
    el.removeEventListener('click', onClickHandler)
    el.addEventListener('click', onClickHandler)
  })
}

function onClickHandler(event: Event): void {
  for (const el of event.composedPath()) {
    try {
      const clickId = (el as EventTarget & { getAttribute(name: string): string }).getAttribute('php-click')
      if (!clickId)
        continue;

      onAction(ActionType.Click, {clickId})
    } catch (ignored) {}
  }
}

function attachChangeListeners(): void {
  document.querySelectorAll('[php-change]').forEach((el: Element) => {
    el.removeEventListener('change', onChangeHandler)
    el.addEventListener('change', onChangeHandler)
  })

  document.querySelectorAll('[php-value][php-watch]').forEach((el: Element) => {
    el.removeEventListener('change', onWatchHandler)
    el.addEventListener('change', onWatchHandler)
  })
}

function onChangeHandler(event: Event): void {
  const element = event.target as HTMLInputElement
  const changeId = element.getAttribute('php-change')

  onAction(ActionType.Change, {changeId, value: element.value})
}

function onWatchHandler(event: Event): void {
  const element = event.target as HTMLInputElement
  const changeId = element.getAttribute('php-value')

  onAction(ActionType.Change, {changeId, value: element.value})
}
