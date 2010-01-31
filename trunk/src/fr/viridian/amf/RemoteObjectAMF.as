package fr.viridian.amf
{
	import mx.collections.ArrayCollection;
	import mx.messaging.ChannelSet;
	import mx.messaging.channels.AMFChannel;
	import mx.rpc.AbstractOperation;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.Operation;
	import mx.rpc.remoting.RemoteObject;

	public class RemoteObjectAMF extends RemoteObject
	{
		private var _channel:AMFChannel;
		private var _channelSet:ChannelSet;
		private var _url:String = "";
		
		public function RemoteObjectAMF(destination:String=null)
		{
			super(destination);
			this.showBusyCursor = false;
		}
		
		public function get url():String {
			return _url;
		}
		public function set url(url:String):void {
			_url = url;
			if ((_url) && (_url != "")) {
				_channel = new AMFChannel("amf", _url);
				_channelSet = new ChannelSet();
				_channelSet.addChannel(_channel);
			} else {
				_channel = null;
				_channelSet = null;
			}
			this.channelSet = _channelSet;
		}
		
		public function executeService(nomService:String, resultHandler:Function=null, faultHandler:Function=null, ...parametres:*):void {
			var service:AbstractOperation = this.getOperation(nomService);
			if (parametres) {
				service.arguments = parametres;
			}
			if (resultHandler != null) {
				service.addEventListener(ResultEvent.RESULT, resultHandler);
			}
			if (faultHandler != null) {
				service.addEventListener(FaultEvent.FAULT, faultHandler);
			}
			service.send();
		}
	}
}