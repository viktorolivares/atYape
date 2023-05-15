import emitter from 'tiny-emitter/instance';

export default {
  $on: emitter.on.bind(emitter),
  $once: emitter.once.bind(emitter),
  $off: emitter.off.bind(emitter),
  $emit: emitter.emit.bind(emitter)
};
